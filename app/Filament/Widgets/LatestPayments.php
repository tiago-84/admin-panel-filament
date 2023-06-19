<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;

class LatestPayments extends BaseWidget
{  
    protected static ?int $sort = 2; 

    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): EloquentBuilder|Relation
    {
        return Payment::with('product')->latest()->take(5);   
    }
    

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('created_at')->label('Time'),
            TextColumn::make('total')->money(),
            TextColumn::make('product.name'),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
