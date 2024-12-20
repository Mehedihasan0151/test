<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Note;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\NoteResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NoteResource\RelationManagers;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class NoteResource extends Resource
{
    protected static ?string $model = Note::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('chapter')->required(),
                Select::make('subject')
                    ->options([
                        'accounting' => 'Accounting',
                        'advance-java' => 'Advance java',
                        'web-design 2' => 'Web design 2',
                        'computer-architecture' => 'Computer architecture',
                        'cata-communication' => 'Data communication',
                        'operating-system' => 'Operating system',
                        'project-work-1' => 'Project work-1',
                    ])
                    ->required(),
                FileUpload::make('image')
                    ->image()
                    ->multiple()
                    ->directory('note-images')
                    ->required()
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string 
                            => Carbon::now()->format('YmdHis') . '.' . $file->getClientOriginalExtension()
                    )
                    //------- for size limit and custom massege
                    ->maxSize(15000) // Limit in kilobytes (15,360 KB = 15 MB)
                    ->rules(['max:15000'])
                    ->validationMessages([
                        'max' => 'The image must not exceed 15 MB in size.'
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('chapter')->sortable()->searchable(),
                TextColumn::make('subject')->sortable(),
                ImageColumn::make('image'),
            ])

            ->filters([
                SelectFilter::make('subject')
                    ->options([
                        'accounting' => 'Accounting',
                        'advance-java' => 'Advance java',
                        'web-design 2' => 'Web design 2',
                        'computer-architecture' => 'Computer architecture',
                        'cata-communication' => 'Data communication',
                        'operating-system' => 'Operating system',
                        'project-work-1' => 'Project work-1',
                    ])
                    // ->query(function (Builder $query, $state) {
                    //     if (isset($state['value']) && $state['value'] !== null) {
                    //         $query->where('subject', $state['value']);
                    //     }
                    // })
                    

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNote::route('/create'),
            'edit' => Pages\EditNote::route('/{record}/edit'),
        ];
    }
}
