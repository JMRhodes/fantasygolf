<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PlayerResource\Pages\CreatePlayer;
use App\Filament\Admin\Resources\PlayerResource\Pages\EditPlayer;
use App\Filament\Admin\Resources\PlayerResource\Pages\ListPlayers;
use App\Models\Player;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static ?string $navigationIcon = 'phosphor-identification-badge-duotone';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Player Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('pga_id')
                            ->label('PGA ID')
                            ->required()
                            ->numeric()
                            ->maxLength(8),
                        TextInput::make('salary')
                            ->prefixIcon('phosphor-currency-dollar-duotone')
                            ->required()
                            ->numeric(),
                    ])
                    ->columnSpan(8),
                Section::make()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('avatar')
                            ->avatar()
                            ->collection('player'),
                    ])
                    ->columnSpan(4),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('player')
                    ->circular()
                    ->size(38)
                    ->label(''),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('salary')
                    ->numeric()
                    ->prefix('$')
                    ->sortable(),
                TextColumn::make('total_points')
                    ->label('Points')
                    ->numeric(),
            ])
            ->defaultPaginationPageOption(50)
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlayers::route('/'),
            'create' => CreatePlayer::route('/create'),
            'edit' => EditPlayer::route('/{record}/edit'),
        ];
    }
}
