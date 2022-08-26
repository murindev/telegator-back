<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CreateCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create categories';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cats = [
            'auto' => 'авто',
            'business' => 'бизнес и финансы',
            'blogs' => 'блоги',
            'bookmaking' => 'букмекерство',
            'video' => 'видео и фильмы',
            'design' => 'дизайн',
            'adult' => 'для взрослых',
            'food' => 'еда и кулинария',
            'animals' => 'животные',
            'health' => 'здоровье и фитнес',
            'games' => 'игры',
            'instagram' => 'инстаграм',
            'art' => 'искусство',
            'photo' => 'картинки и фото',
            'career' => 'карьера',
            'books' => 'книги',
            'cryptocurrencies' => 'криптовалюты',
            'guide' => 'курсы и гайды',
            'life hacks' => 'лайфхаки',
            'linguistics' => 'лингвистика',
            'marketing' => 'маркетинг',
            'media' => 'медиа',
            'medicine' => 'медицина',
            'fashion and beauty' => 'мода и красота',
            'Moscow' => 'Москва',
            'music' => 'музыка',
            'science' => 'наука',
            'property' => 'недвижимость',
            'news' => 'новости и СМИ',
            'education' => 'образование',
            'politics' => 'политика',
            'jurisprudence' => 'право',
            'psychology' => 'психология',
            'travels' => 'путешествия',
            'entertainment' => 'развлечения',
            'regional' => 'региональные',
            'religion' => 'религия',
            'handmade' => 'рукоделие',
            'Saint-Petersburg' => 'Санкт-Петербург',
            'family' => 'семья и дети',
            'discount' => 'скидки и акции',
            'soft' => 'софт и приложения',
            'sport' => 'спорт',
            'stickers' => 'стикеры',
            'technologies' => 'технологии',
            'shock content' => 'шок-контент',
            'economy' => 'экономика',
            'erotica' => 'эротика',
            'humor' => 'юмор',
            'Telegram' => 'Telegram',
            'other' => 'другое'
        ];

        $created = 0;
        $updated = 0;

        $now = Carbon::now();

        foreach ($cats as $name => $label) {
            $model = Category::firstOrCreate(
                ['name'  => $name],
                ['label' => $label]
            );

            if ($model->created_at < $now) $updated++;
            else $created++;
        }

        $this->line("Created: $created");
        $this->line("Updated: $updated");

        return 1;
    }
}
