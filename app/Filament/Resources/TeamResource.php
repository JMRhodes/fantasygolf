<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages\CreateTeam;
use App\Filament\Resources\TeamResource\Pages\EditTeam;
use App\Filament\Resources\TeamResource\Pages\ListTeams;
use App\Filament\Resources\TeamResource\RelationManagers\PlayersRelationManager;
use App\Models\Team;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'phosphor-address-book-tabs-duotone';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Team Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(128),
                        Select::make('user_id')
                            ->relationship(name: 'user', titleAttribute: 'name')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('user.gravatar')
                        ->circular()
                        ->label('Avatar')
                        ->grow(false)
                        ->searchable(),
                    Stack::make([
                        TextColumn::make('name')
                            ->searchable(),
                        TextColumn::make('user.email')
                            ->size('xs')
                            ->color(Color::Gray)
                            ->searchable(),
                    ]),
                    ImageColumn::make('players.avatar')
                        ->circular()
                        ->stacked()
                        ->limit(4)
                        ->wrap(),
                    TextColumn::make('points')
                        ->grow(false)
                        ->default(0)
                        ->badge()
                        ->color(Color::Gray)
                        ->suffix(' pts'),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PlayersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeams::route('/'),
            'create' => CreateTeam::route('/create'),
            'edit' => EditTeam::route('/{record}/edit'),
        ];
    }
}
