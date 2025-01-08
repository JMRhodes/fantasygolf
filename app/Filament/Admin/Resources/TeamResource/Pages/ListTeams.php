<?php

namespace App\Filament\Admin\Resources\TeamResource\Pages;

use App\Filament\Admin\Resources\TeamResource;
use App\Models\Team;
use App\Pipes\CalculatePoints;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Illuminate\Pipeline\Pipeline;

class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('refresh:teams')
                ->label('Refresh Teams')
                ->color(Color::Green)
                ->requiresConfirmation()
                ->modalHeading('Sync All Team Data')
                ->action(function (Pipeline $pipeline) {
                    $teams = Team::all();

                    $pipeline->send($teams)
                        ->through([
                            CalculatePoints::class,
                        ])
                        ->then(function () {
                            Notification::make()
                                ->title(__('Team Data Synced'))
                                ->success()
                                ->seconds(5)
                                ->send();
                        });
                }),
        ];
    }
}
