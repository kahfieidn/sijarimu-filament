<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\StatusPermohonan;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StatusPermohonanResource\Pages;
use App\Filament\Resources\StatusPermohonanResource\RelationManagers;


class StatusPermohonanResource extends Resource
{
    protected static ?string $model = StatusPermohonan::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'Administrator';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Status Permohonan')
                    ->schema([
                        Forms\Components\TextInput::make('nama_status')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('icon')
                            ->searchable()
                            ->options([
                                'heroicon-o-check-badge' => 'Check Badge',
                                'heroicon-o-academic-cap' => 'Academic Cap',
                                'heroicon-o-adjustments-horizontal' => 'Adjustments Horizontal',
                                'heroicon-o-adjustments-vertical' => 'Adjustments Vertical',
                                'heroicon-o-archive-box-arrow-down' => 'Archive Box Arrow Down',
                                'heroicon-o-archive-box-x-mark' => 'Archive Box X Mark',
                                'heroicon-o-archive-box' => 'Archive Box',
                                'heroicon-o-arrow-down-circle' => 'Arrow Down Circle',
                                'heroicon-o-arrow-down-left' => 'Arrow Down Left',
                                'heroicon-o-arrow-down-on-square-stack' => 'Arrow Down On Square Stack',
                                'heroicon-o-arrow-down-on-square' => 'Arrow Down On Square',
                                'heroicon-o-arrow-down-right' => 'Arrow Down Right',
                                'heroicon-o-arrow-down-tray' => 'Arrow Down Tray',
                                'heroicon-o-arrow-down' => 'Arrow Down',
                                'heroicon-o-arrow-left-circle' => 'Arrow Left Circle',
                                'heroicon-o-arrow-left-end-on-rectangle' => 'Arrow Left End On Rectangle',
                                'heroicon-o-arrow-left-start-on-rectangle' => 'Arrow Left Start On Rectangle',
                                'heroicon-o-arrow-left' => 'Arrow Left',
                                'heroicon-o-arrow-long-down' => 'Arrow Long Down',
                                'heroicon-o-arrow-long-left' => 'Arrow Long Left',
                                'heroicon-o-arrow-long-right' => 'Arrow Long Right',
                                'heroicon-o-arrow-long-up' => 'Arrow Long Up',
                                'heroicon-o-arrow-path-rounded-square' => 'Arrow Path Rounded Square',
                                'heroicon-o-arrow-path' => 'Arrow Path',
                                'heroicon-o-arrow-right-circle' => 'Arrow Right Circle',
                                'heroicon-o-arrow-right-end-on-rectangle' => 'Arrow Right End On Rectangle',
                                'heroicon-o-arrow-right-start-on-rectangle' => 'Arrow Right Start On Rectangle',
                                'heroicon-o-arrow-right' => 'Arrow Right',
                                'heroicon-o-arrow-top-right-on-square' => 'Arrow Top Right On Square',
                                'heroicon-o-arrow-trending-down' => 'Arrow Trending Down',
                                'heroicon-o-arrow-trending-up' => 'Arrow Trending Up',
                                'heroicon-o-arrow-up-circle' => 'Arrow Up Circle',
                                'heroicon-o-arrow-up-left' => 'Arrow Up Left',
                                'heroicon-o-arrow-up-on-square-stack' => 'Arrow Up On Square Stack',
                                'heroicon-o-arrow-up-on-square' => 'Arrow Up On Square',
                                'heroicon-o-arrow-up-right' => 'Arrow Up Right',
                                'heroicon-o-arrow-up-tray' => 'Arrow Up Tray',
                                'heroicon-o-arrow-up' => 'Arrow Up',
                                'heroicon-o-arrow-uturn-down' => 'Arrow Uturn Down',
                                'heroicon-o-arrow-uturn-left' => 'Arrow Uturn Left',
                                'heroicon-o-arrow-uturn-right' => 'Arrow Uturn Right',
                                'heroicon-o-arrow-uturn-up' => 'Arrow Uturn Up',
                                'heroicon-o-arrows-pointing-in' => 'Arrows Pointing In',
                                'heroicon-o-arrows-pointing-out' => 'Arrows Pointing Out',
                                'heroicon-o-arrows-right-left' => 'Arrows Right Left',
                                'heroicon-o-arrows-up-down' => 'Arrows Up Down',
                                'heroicon-o-at-symbol' => 'At Symbol',
                                'heroicon-o-backspace' => 'Backspace',
                                'heroicon-o-backward' => 'Backward',
                                'heroicon-o-banknotes' => 'Banknotes',
                                'heroicon-o-bars-2' => 'Bars 2',
                                'heroicon-o-bars-3-bottom-left' => 'Bars 3 Bottom Left',
                                'heroicon-o-bars-3-bottom-right' => 'Bars 3 Bottom Right',
                                'heroicon-o-bars-3-center-left' => 'Bars 3 Center Left',
                                'heroicon-o-bars-3' => 'Bars 3',
                                'heroicon-o-bars-4' => 'Bars 4',
                                'heroicon-o-bars-arrow-down' => 'Bars Arrow Down',
                                'heroicon-o-bars-arrow-up' => 'Bars Arrow Up',
                                'heroicon-o-battery-0' => 'Battery 0',
                                'heroicon-o-battery-100' => 'Battery 100',
                                'heroicon-o-battery-50' => 'Battery 50',
                                'heroicon-o-beaker' => 'Beaker',
                                'heroicon-o-bell-alert' => 'Bell Alert',
                                'heroicon-o-bell-slash' => 'Bell Slash',
                                'heroicon-o-bell-snooze' => 'Bell Snooze',
                                'heroicon-o-bell' => 'Bell',
                                'heroicon-o-bolt-slash' => 'Bolt Slash',
                                'heroicon-o-bolt' => 'Bolt',
                                'heroicon-o-book-open' => 'Book Open',
                                'heroicon-o-bookmark-slash' => 'Bookmark Slash',
                                'heroicon-o-bookmark-square' => 'Bookmark Square',
                                'heroicon-o-bookmark' => 'Bookmark',
                                'heroicon-o-briefcase' => 'Briefcase',
                                'heroicon-o-bug-ant' => 'Bug Ant',
                                'heroicon-o-building-library' => 'Building Library',
                                'heroicon-o-building-office-2' => 'Building Office 2',
                                'heroicon-o-building-office' => 'Building Office',
                                'heroicon-o-building-storefront' => 'Building Storefront',
                                'heroicon-o-cake' => 'Cake',
                                'heroicon-o-calculator' => 'Calculator',
                                'heroicon-o-calendar-days' => 'Calendar Days',
                                'heroicon-o-calendar' => 'Calendar',
                                'heroicon-o-camera' => 'Camera',
                                'heroicon-o-chart-bar-square' => 'Chart Bar Square',
                                'heroicon-o-chart-bar' => 'Chart Bar',
                                'heroicon-o-chart-pie' => 'Chart Pie',
                                'heroicon-o-chat-bubble-bottom-center-text' => 'Chat Bubble Bottom Center Text',
                                'heroicon-o-chat-bubble-bottom-center' => 'Chat Bubble Bottom Center',
                                'heroicon-o-chat-bubble-left-ellipsis' => 'Chat Bubble Left Ellipsis',
                                'heroicon-o-chat-bubble-left-right' => 'Chat Bubble Left Right',
                                'heroicon-o-chat-bubble-left' => 'Chat Bubble Left',
                                'heroicon-o-chat-bubble-oval-left-ellipsis' => 'Chat Bubble Oval Left Ellipsis',
                                'heroicon-o-chat-bubble-oval-left' => 'Chat Bubble Oval Left',
                                'heroicon-o-check-badge' => 'Check Badge',
                                'heroicon-o-check-circle' => 'Check Circle',
                                'heroicon-o-check' => 'Check',
                                'heroicon-o-chevron-double-down' => 'Chevron Double Down',
                                'heroicon-o-chevron-double-left' => 'Chevron Double Left',
                                'heroicon-o-chevron-double-right' => 'Chevron Double Right',
                                'heroicon-o-chevron-double-up' => 'Chevron Double Up',
                                'heroicon-o-chevron-down' => 'Chevron Down',
                                'heroicon-o-chevron-left' => 'Chevron Left',
                                'heroicon-o-chevron-right' => 'Chevron Right',
                                'heroicon-o-chevron-up-down' => 'Chevron Up Down',
                                'heroicon-o-chevron-up' => 'Chevron Up',
                                'heroicon-o-circle-stack' => 'Circle Stack',
                                'heroicon-o-clipboard-document-check' => 'Clipboard Document Check',
                                'heroicon-o-clipboard-document-list' => 'Clipboard Document List',
                                'heroicon-o-clipboard-document' => 'Clipboard Document',
                                'heroicon-o-clipboard' => 'Clipboard',
                                'heroicon-o-clock' => 'Clock',
                                'heroicon-o-cloud-arrow-down' => 'Cloud Arrow Down',
                                'heroicon-o-cloud-arrow-up' => 'Cloud Arrow Up',
                                'heroicon-o-cloud' => 'Cloud',
                                'heroicon-o-code-bracket-square' => 'Code Bracket Square',
                                'heroicon-o-code-bracket' => 'Code Bracket',
                                'heroicon-o-cog-6-tooth' => 'Cog 6 Tooth',
                                'heroicon-o-cog-8-tooth' => 'Cog 8 Tooth',
                                'heroicon-o-cog' => 'Cog',
                                'heroicon-o-command-line' => 'Command Line',
                                'heroicon-o-computer-desktop' => 'Computer Desktop',
                                'heroicon-o-cpu-chip' => 'CPU Chip',
                                'heroicon-o-credit-card' => 'Credit Card',
                                'heroicon-o-cube-transparent' => 'Cube Transparent',
                                'heroicon-o-cube' => 'Cube',
                                'heroicon-o-currency-bangladeshi' => 'Currency Bangladeshi',
                                'heroicon-o-currency-dollar' => 'Currency Dollar',
                                'heroicon-o-currency-euro' => 'Currency Euro',
                                'heroicon-o-currency-pound' => 'Currency Pound',
                                'heroicon-o-currency-rupee' => 'Currency Rupee',
                                'heroicon-o-currency-yen' => 'Currency Yen',
                                'heroicon-o-cursor-arrow-rays' => 'Cursor Arrow Rays',
                                'heroicon-o-cursor-arrow-ripple' => 'Cursor Arrow Ripple',
                                'heroicon-o-device-phone-mobile' => 'Device Phone Mobile',
                                'heroicon-o-device-tablet' => 'Device Tablet',
                                'heroicon-o-document-arrow-down' => 'Document Arrow Down',
                                'heroicon-o-document-arrow-up' => 'Document Arrow Up',
                                'heroicon-o-document-chart-bar' => 'Document Chart Bar',
                                'heroicon-o-document-check' => 'Document Check',
                                'heroicon-o-document-duplicate' => 'Document Duplicate',
                                'heroicon-o-document-magnifying-glass' => 'Document Magnifying Glass',
                                'heroicon-o-document-minus' => 'Document Minus',
                                'heroicon-o-document-plus' => 'Document Plus',
                                'heroicon-o-document-text' => 'Document Text',
                                'heroicon-o-document' => 'Document',
                                'heroicon-o-ellipsis-horizontal-circle' => 'Ellipsis Horizontal Circle',
                                'heroicon-o-ellipsis-horizontal' => 'Ellipsis Horizontal',
                                'heroicon-o-ellipsis-vertical' => 'Ellipsis Vertical',
                                'heroicon-o-envelope-open' => 'Envelope Open',
                                'heroicon-o-envelope' => 'Envelope',
                                'heroicon-o-exclamation-circle' => 'Exclamation Circle',
                                'heroicon-o-exclamation-triangle' => 'Exclamation Triangle',
                                'heroicon-o-eye-dropper' => 'Eye Dropper',
                                'heroicon-o-eye-slash' => 'Eye Slash',
                                'heroicon-o-eye' => 'Eye',
                                'heroicon-o-face-frown' => 'Face Frown',
                                'heroicon-o-face-smile' => 'Face Smile',
                                'heroicon-o-film' => 'Film',
                                'heroicon-o-finger-print' => 'Finger Print',
                                'heroicon-o-fire' => 'Fire',
                                'heroicon-o-flag' => 'Flag',
                                'heroicon-o-folder-arrow-down' => 'Folder Arrow Down',
                                'heroicon-o-folder-minus' => 'Folder Minus',
                                'heroicon-o-folder-open' => 'Folder Open',
                                'heroicon-o-folder-plus' => 'Folder Plus',
                                'heroicon-o-folder' => 'Folder',
                                'heroicon-o-forward' => 'Forward',
                                'heroicon-o-funnel' => 'Funnel',
                                'heroicon-o-gif' => 'GIF',
                                'heroicon-o-gift-top' => 'Gift Top',
                                'heroicon-o-gift' => 'Gift',
                                'heroicon-o-globe-alt' => 'Globe Alt',
                                'heroicon-o-globe-americas' => 'Globe Americas',
                                'heroicon-o-globe-asia-australia' => 'Globe Asia Australia',
                                'heroicon-o-globe-europe-africa' => 'Globe Europe Africa',
                                'heroicon-o-hand-raised' => 'Hand Raised',
                                'heroicon-o-hand-thumb-down' => 'Hand Thumb Down',
                                'heroicon-o-hand-thumb-up' => 'Hand Thumb Up',
                                'heroicon-o-hashtag' => 'Hashtag',
                                'heroicon-o-heart' => 'Heart',
                                'heroicon-o-home-modern' => 'Home Modern',
                                'heroicon-o-home' => 'Home',
                                'heroicon-o-identification' => 'Identification',
                                'heroicon-o-inbox-arrow-down' => 'Inbox Arrow Down',
                                'heroicon-o-inbox-stack' => 'Inbox Stack',
                                'heroicon-o-inbox' => 'Inbox',
                                'heroicon-o-information-circle' => 'Information Circle',
                                'heroicon-o-key' => 'Key',
                                'heroicon-o-language' => 'Language',
                                'heroicon-o-lifebuoy' => 'Lifebuoy',
                                'heroicon-o-light-bulb' => 'Light Bulb',
                                'heroicon-o-link' => 'Link',
                                'heroicon-o-list-bullet' => 'List Bullet',
                                'heroicon-o-lock-closed' => 'Lock Closed',
                                'heroicon-o-lock-open' => 'Lock Open',
                                'heroicon-o-magnifying-glass-circle' => 'Magnifying Glass Circle',
                                'heroicon-o-magnifying-glass-minus' => 'Magnifying Glass Minus',
                                'heroicon-o-magnifying-glass-plus' => 'Magnifying Glass Plus',
                                'heroicon-o-magnifying-glass' => 'Magnifying Glass',
                                'heroicon-o-map-pin' => 'Map Pin',
                                'heroicon-o-map' => 'Map',
                                'heroicon-o-megaphone' => 'Megaphone',
                                'heroicon-o-microphone' => 'Microphone',
                                'heroicon-o-minus-circle' => 'Minus Circle',
                                'heroicon-o-minus' => 'Minus',
                                'heroicon-o-moon' => 'Moon',
                                'heroicon-o-musical-note' => 'Musical Note',
                                'heroicon-o-newspaper' => 'Newspaper',
                                'heroicon-o-no-symbol' => 'No Symbol',
                                'heroicon-o-paint-brush' => 'Paint Brush',
                                'heroicon-o-paper-airplane' => 'Paper Airplane',
                                'heroicon-o-paper-clip' => 'Paper Clip',
                                'heroicon-o-pause-circle' => 'Pause Circle',
                                'heroicon-o-pause' => 'Pause',
                                'heroicon-o-pencil-square' => 'Pencil Square',
                                'heroicon-o-pencil' => 'Pencil',
                                'heroicon-o-phone-arrow-down-left' => 'Phone Arrow Down Left',
                                'heroicon-o-phone-arrow-up-right' => 'Phone Arrow Up Right',
                                'heroicon-o-phone-x-mark' => 'Phone X Mark',
                                'heroicon-o-phone' => 'Phone',
                                'heroicon-o-photo' => 'Photo',
                                'heroicon-o-play-circle' => 'Play Circle',
                                'heroicon-o-play-pause' => 'Play Pause',
                                'heroicon-o-play' => 'Play',
                                'heroicon-o-plus-circle' => 'Plus Circle',
                                'heroicon-o-plus' => 'Plus',
                                'heroicon-o-power' => 'Power',
                                'heroicon-o-presentation-chart-bar' => 'Presentation Chart Bar',
                                'heroicon-o-presentation-chart-line' => 'Presentation Chart Line',
                                'heroicon-o-printer' => 'Printer',
                                'heroicon-o-puzzle-piece' => 'Puzzle Piece',
                                'heroicon-o-qr-code' => 'QR Code',
                                'heroicon-o-question-mark-circle' => 'Question Mark Circle',
                                'heroicon-o-queue-list' => 'Queue List',
                                'heroicon-o-radio' => 'Radio',
                                'heroicon-o-receipt-percent' => 'Receipt Percent',
                                'heroicon-o-receipt-refund' => 'Receipt Refund',
                                'heroicon-o-rectangle-group' => 'Rectangle Group',
                                'heroicon-o-rectangle-stack' => 'Rectangle Stack',
                                'heroicon-o-rocket-launch' => 'Rocket Launch',
                                'heroicon-o-rss' => 'RSS',
                                'heroicon-o-scale' => 'Scale',
                                'heroicon-o-scissors' => 'Scissors',
                                'heroicon-o-server-stack' => 'Server Stack',
                                'heroicon-o-server' => 'Server',
                                'heroicon-o-share' => 'Share',
                                'heroicon-o-shield-check' => 'Shield Check',
                                'heroicon-o-shield-exclamation' => 'Shield Exclamation',
                                'heroicon-o-shopping-bag' => 'Shopping Bag',
                                'heroicon-o-shopping-cart' => 'Shopping Cart',
                                'heroicon-o-signal-slash' => 'Signal Slash',
                                'heroicon-o-signal' => 'Signal',
                                'heroicon-o-sparkles' => 'Sparkles',
                                'heroicon-o-speaker-wave' => 'Speaker Wave',
                                'heroicon-o-speaker-x-mark' => 'Speaker X Mark',
                                'heroicon-o-square-2-stack' => 'Square 2 Stack',
                                'heroicon-o-square-3-stack-3d' => 'Square 3 Stack 3D',
                                'heroicon-o-squares-2x2' => 'Squares 2x2',
                                'heroicon-o-squares-plus' => 'Squares Plus',
                                'heroicon-o-star' => 'Star',
                                'heroicon-o-stop-circle' => 'Stop Circle',
                                'heroicon-o-stop' => 'Stop',
                                'heroicon-o-sun' => 'Sun',
                                'heroicon-o-swatch' => 'Swatch',
                                'heroicon-o-table-cells' => 'Table Cells',
                                'heroicon-o-tag' => 'Tag',
                                'heroicon-o-ticket' => 'Ticket',
                                'heroicon-o-trash' => 'Trash',
                                'heroicon-o-trophy' => 'Trophy',
                                'heroicon-o-truck' => 'Truck',
                                'heroicon-o-tv' => 'TV',
                                'heroicon-o-user-circle' => 'User Circle',
                                'heroicon-o-user-group' => 'User Group',
                                'heroicon-o-user-minus' => 'User Minus',
                                'heroicon-o-user-plus' => 'User Plus',
                                'heroicon-o-user' => 'User',
                                'heroicon-o-users' => 'Users',
                                'heroicon-o-variable' => 'Variable',
                                'heroicon-o-video-camera-slash' => 'Video Camera Slash',
                                'heroicon-o-video-camera' => 'Video Camera',
                                'heroicon-o-view-columns' => 'View Columns',
                                'heroicon-o-viewfinder-circle' => 'Viewfinder Circle',
                                'heroicon-o-wallet' => 'Wallet',
                                'heroicon-o-wifi' => 'WiFi',
                                'heroicon-o-window' => 'Window',
                                'heroicon-o-wrench-screwdriver' => 'Wrench Screwdriver',
                                'heroicon-o-wrench' => 'Wrench',
                                'heroicon-o-x-circle' => 'X Circle',
                                'heroicon-o-x-mark' => 'X Mark',
                            ])
                            ->required(),
                        Forms\Components\Select::make('color')
                            ->options([
                                'danger' => 'danger',
                                'gray' => 'gray',
                                'info' => 'info',
                                'primary' => 'primary',
                                'success' => 'success',
                                'warning' => 'warning',
                            ])
                            ->required(),
                        Forms\Components\Select::make('role_id')
                            ->options(Role::all()->pluck('name', 'id')->toArray())
                            ->multiple()
                            ->searchable()
                            ->required(),
                    ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStatusPermohonans::route('/'),
            'create' => Pages\CreateStatusPermohonan::route('/create'),
            'view' => Pages\ViewStatusPermohonan::route('/{record}'),
            'edit' => Pages\EditStatusPermohonan::route('/{record}/edit'),
        ];
    }
}
