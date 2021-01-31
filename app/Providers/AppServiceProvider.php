<?php

namespace App\Providers;

use App\Modules\LockModule\Interfaces\LockInterface;
use App\Modules\LockModule\Services\LockService;
use App\Modules\MessagesModule\Interfaces\MessageParserInterface;
use App\Modules\MessagesModule\Interfaces\MessageRepositoryInterface;
use App\Modules\MessagesModule\Interfaces\MessageSerializerInterface;
use App\Modules\MessagesModule\Interfaces\XmlStoreInterface;
use App\Modules\MessagesModule\Repositories\XmlMessageRepository;
use App\Modules\MessagesModule\Service\Store\MessageParserService;
use App\Modules\MessagesModule\Service\Store\MessageSerializerService;
use App\Modules\MessagesModule\Stores\XmlMessageStore;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MessageParserInterface::class, function () {
            return new MessageParserService();
        });
        $this->app->bind(MessageSerializerInterface::class, function () {
            return new MessageSerializerService();
        });
        $this->app->bind(LockInterface::class, function () {
            return new LockService();
        });

        $xmpMessageStore = new XmlMessageStore(
            new MessageParserService(),
            new MessageSerializerService()
        );

        $this->app->bind(XmlStoreInterface::class, function () use ($xmpMessageStore) {
            return $xmpMessageStore;
        });

        $this->app->singleton(MessageRepositoryInterface::class, function () use ($xmpMessageStore) {
            return new XmlMessageRepository($xmpMessageStore);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
