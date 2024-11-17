<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingReservasiResource\Pages;
use App\Filament\Resources\PendingReservasiResource\RelationManagers;
use App\Filament\Resources\ReservasiResource\Pages\ViewReservasi;
use App\Models\Reservasi;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendingReservasiResource extends Resource
{
    protected static ?string $model = Reservasi::class;
    protected static ?string $navigationLabel = 'Pending Reservasi';
    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Info Customer & Order')
                ->relationship('customer')
                ->Schema([
                    TextInput::make('name')->label('nama'),
                    TextInput::make('phone')->label('no telp'),
                    Textarea::make('order')
                        ->label('order'),
                    TextArea::make('note'),
                ])->columnSpanFull(),
                Section::make('Info Ruangan & Waktu')
                ->Schema([
                    Select::make('room')->label('ruangan')->relationship('room', 'room_name'),
                    DatePicker::make('tanggal')->label('tanggal')->required()->native(false),
                    TimePicker::make('jam_mulai')->label('jam mulai')->required()->seconds(false),
                    TimePicker::make('jam_selesai')->label('jam selesai')->required()->seconds(false),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // modify query to only show pending reservasi and with descending tanggal
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('status', 'pending')->orderBy('tanggal', 'desc');
            })
            ->columns([
                TextColumn::make('kode_reservasi'),
                TextColumn::make('tanggal')->dateTime('j F Y'),
                TextColumn::make('jam_mulai')->dateTime('H:i'),
                TextColumn::make('jam_selesai')->dateTime('H:i'), 
                TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                })
            ])
            ->filters([

                
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make('view')
                ->label('Detail')
                ->icon('heroicon-o-eye')
                ->form([
                    Section::make('Info Customer & Order')
                    ->relationship('customer')
                    ->Schema([
                        TextInput::make('name')->label('nama')->disabled(),
                        TextInput::make('phone')->label('no telp')->disabled(),
                        Textarea::make('order')
                            ->label('order'),
                        TextArea::make('note'),
                    ])->columnSpanFull(),
                    Section::make('Info Ruangan & Waktu')
                    ->Schema([
                        Select::make('room')->label('ruangan')->relationship('room', 'room_name'),
                        DatePicker::make('tanggal')->label('tanggal')->required()->native(false),
                        TimePicker::make('jam_mulai')->label('jam mulai')->required()->seconds(false),
                        TimePicker::make('jam_selesai')->label('jam selesai')->required()->seconds(false),
                    ])
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPendingReservasis::route('/'),
            // 'create' => Pages\CreatePendingReservasi::route('/create'),
            'edit' => Pages\EditPendingReservasi::route('/{record}/edit'),
            'view' => ViewReservasi::route('/{record}'),
        ];
    }
}
