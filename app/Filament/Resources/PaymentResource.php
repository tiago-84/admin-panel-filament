<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use App\Filament\Resources\UserResource;


class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'shop';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Payment time')->sortable(),
                TextColumn::make('product.name')
                    ->url(fn (Payment $record) => ProductResource::getUrl('edit', ['record' => $record->product])),
                TextColumn::make('user.name')->label('User name')
                    ->url(fn (Payment $record) => UserResource::getUrl('edit', ['record' => $record->user   ])),
                TextColumn::make('user.email')->label('User email'),
                TextColumn::make('voucher.code'),
                TextColumn::make('subtotal')->money('usd'),
                TextColumn::make('taxes')->money('usd'),
                TextColumn::make('total')->money('usd'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
            Filter::make('created_at')
            ->form([
                DatePicker::make('created_from'),
                DatePicker::make('created_until'),

            ])
            ->query(function ($query, array $data) {
                return $query
                ->when(
                    $data['created_from'],
                    fn ($query) => $query->whereDate('created_at', '>=', $data['created_from'])
                )
                ->when(
                    $data['created_until'],
                    fn ($query) => $query->whereDate('created_at', '<=', $data['created_until']));


                })

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
            'index' => Pages\ListPayments::route('/'),

        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
