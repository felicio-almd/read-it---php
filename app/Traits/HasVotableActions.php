<?php

declare(strict_types=1);

namespace App\Traits;

use Filament\Notifications\Notification;
use App\Actions\VoteOnPostAction;
use Filament\Actions\Action;

trait HasVotableActions
{
    public ?string $userVote = null;

    public int $voteCount = 0;

    public function mountHasVotableActions(): void
    {
        $this->loadVoteState();
    }

    protected function loadVoteState(): void
    {
        $record = $this->getRecord();
        $user = auth()->user();

        if (! $record || ! $user) {
            return;
        }

        $vote = $record->votes()
            ->where('user_id', $user->id)
            ->first();

        $this->userVote = $vote?->vote_type;
        $this->voteCount = $record->votes_count ?? $record->votes()->count();
    }

    protected function refreshVoteState(): void
    {
        $this->loadVoteState();
        $this->dispatch('vote-updated');
    }

    protected function getUpvoteAction(): Action
    {
        return Action::make('upvote')
            ->icon($this->userVote === 'up' ? 'heroicon-s-arrow-up' : 'heroicon-o-arrow-up')
            ->color($this->userVote === 'up' ? 'success' : 'gray')
            ->label(fn () => $this->getVoteLabel('up'))
            ->requiresConfirmation(false)
            ->action(function (VoteOnPostAction $voteAction): void {
                $record = $this->getRecord();
                $user = auth()->user();

                if (! $user) {
                    $this->sendNotification('danger', 'Você precisa estar logado para votar');

                    return;
                }

                if ($this->userVote === 'up') {
                    $voteAction->execute($record, $user, null);
                } else {
                    $voteAction->execute($record, $user, 'up');
                }

                $this->refreshVoteState();
                $this->sendNotification('success', $this->getVoteMessage('up'));
            });
    }

    protected function getDownvoteAction(): Action
    {
        return Action::make('downvote')
            ->icon($this->userVote === 'down' ? 'heroicon-s-arrow-down' : 'heroicon-o-arrow-down')
            ->color($this->userVote === 'down' ? 'danger' : 'gray')
            ->label(fn () => $this->getVoteLabel('down'))
            ->requiresConfirmation(false)
            ->action(function (VoteOnPostAction $voteAction): void {
                $record = $this->getRecord();
                $user = auth()->user();

                if (! $user) {
                    $this->sendNotification('danger', 'Você precisa estar logado para votar');

                    return;
                }

                if ($this->userVote === 'down') {
                    $voteAction->execute($record, $user, null);
                } else {
                    $voteAction->execute($record, $user, 'down');
                }

                $this->refreshVoteState();
                $this->sendNotification('success', $this->getVoteMessage('down'));
            });
    }

    protected function getVoteLabel(string $type): string
    {
        if ($this->userVote === $type) {
            return $type === 'up' ? 'Upvoted' : 'Downvoted';
        }

        return $type === 'up' ? 'Upvote' : 'Downvote';
    }

    protected function getVoteMessage(string $type): string
    {
        if ($this->userVote === $type) {
            return 'Voto removido com sucesso';
        }

        return $type === 'up' ? 'Upvote registrado!' : 'Downvote registrado!';
    }

    protected function sendNotification(string $status, string $message): void
    {
        Notification::make()
            ->title($message)
            ->status($status)
            ->send();
    }
}
