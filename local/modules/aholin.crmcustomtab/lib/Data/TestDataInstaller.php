<?php
namespace Aholin\Crmcustomtab\Data;

use Aholin\Crmcustomtab\Orm\BookTable;
use Aholin\Crmcustomtab\Orm\AuthorTable;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\DateTime;

class TestDataInstaller
{
    public static function addAuthors(): void
    {
        $authors = [
            [
                'FIRST_NAME' => 'Лев',
                'LAST_NAME' => 'Толстой',
                'SECOND_NAME' => 'Николаевич',
                'BIRTH_DATE' => '09.09.1828',
                'BIOGRAPHY' => 'Граф Лев Николаевич Толстой — один из наиболее известных русских писателей и мыслителей, один из величайших писателей-романистов мира. Участник обороны Севастополя. Просветитель, публицист, религиозный мыслитель. Наиболее известные произведения: «Война и мир», «Анна Каренина», «Воскресение».'
            ],
            [
                'FIRST_NAME' => 'Фёдор',
                'LAST_NAME' => 'Достоевский',
                'SECOND_NAME' => 'Михайлович',
                'BIRTH_DATE' => '11.11.1821',
                'BIOGRAPHY' => 'Фёдор Михайлович Достоевский — русский писатель, мыслитель, философ и публицист. Член-корреспондент Петербургской академии наук с 1877 года. Классик мировой литературы, по данным ЮНЕСКО, один из самых читаемых писателей в мире. Наиболее известные произведения: «Преступление и наказание», «Идиот», «Братья Карамазовы».'
            ],
            [
                'FIRST_NAME' => 'Антон',
                'LAST_NAME' => 'Чехов',
                'SECOND_NAME' => 'Павлович',
                'BIRTH_DATE' => '29.01.1860',
                'BIOGRAPHY' => 'Антон Павлович Чехов — русский писатель, прозаик, драматург, врач. Классик мировой литературы. По профессии врач. Один из самых известных драматургов мира. Наиболее известные произведения: «Вишнёвый сад», «Три сестры», «Чайка», рассказы «Дама с собачкой», «Человек в футляре».'
            ],
            [
                'FIRST_NAME' => 'Александр',
                'LAST_NAME' => 'Пушкин',
                'SECOND_NAME' => 'Сергеевич',
                'BIRTH_DATE' => '06.06.1799',
                'BIOGRAPHY' => 'Александр Сергеевич Пушкин — русский поэт, драматург и прозаик, заложивший основы русского реалистического направления, критик и теоретик литературы, историк, публицист; один из самых авторитетных литературных деятелей первой трети XIX века. Наиболее известные произведения: «Евгений Онегин», «Капитанская дочка», «Руслан и Людмила».'
            ],
            [
                'FIRST_NAME' => 'Николай',
                'LAST_NAME' => 'Гоголь',
                'SECOND_NAME' => 'Васильевич',
                'BIRTH_DATE' => '01.04.1809',
                'BIOGRAPHY' => 'Николай Васильевич Гоголь — русский прозаик, драматург, поэт, критик, публицист, признанный одним из классиков русской литературы. Наиболее известные произведения: «Мёртвые души», «Ревизор», «Вечера на хуторе близ Диканьки», «Тарас Бульба».'
            ],
            [
                'FIRST_NAME' => 'Иван',
                'LAST_NAME' => 'Тургенев',
                'SECOND_NAME' => 'Сергеевич',
                'BIRTH_DATE' => '09.11.1818',
                'BIOGRAPHY' => 'Иван Сергеевич Тургенев — русский писатель-реалист, поэт, публицист, драматург, переводчик. Один из классиков русской литературы, внёсших наиболее значительный вклад в её развитие во второй половине XIX века. Наиболее известные произведения: «Отцы и дети», «Дворянское гнездо», «Записки охотника».'
            ],
            [
                'FIRST_NAME' => 'Михаил',
                'LAST_NAME' => 'Булгаков',
                'SECOND_NAME' => 'Афанасьевич',
                'BIRTH_DATE' => '15.05.1891',
                'BIOGRAPHY' => 'Михаил Афанасьевич Булгаков — русский писатель, драматург, театральный режиссёр и актёр. Автор романов, повестей, рассказов, фельетонов, пьес, инсценировок, киносценариев. Наиболее известные произведения: «Мастер и Маргарита», «Собачье сердце», «Белая гвардия», «Дни Турбиных».'
            ],
        ];

        foreach ($authors as $authorData) {
            $authorData['BIRTH_DATE'] = DateTime::createFromText($authorData['BIRTH_DATE']);
            AuthorTable::add($authorData);
        }
    }

    /**
     * @throws SystemException
     * @throws \Exception
     */
    public static function addBooks(): void
    {
        $books = [
            [
                'TITLE' => 'Война и мир',
                'YEAR' => 1869,
                'PAGES' => 1225,
                'DESCRIPTION' => 'Роман-эпопея Льва Толстого',
                'PUBLISH_DATE' => '01.01.1869',
                'AUTHORS' => [1, 2] // Толстой и Достоевский
            ],
            [
                'TITLE' => 'Анна Каренина',
                'YEAR' => 1877,
                'PAGES' => 864,
                'DESCRIPTION' => 'Трагическая история любви',
                'PUBLISH_DATE' => '01.01.1877',
                'AUTHORS' => [1] // Только Толстой
            ],
            [
                'TITLE' => 'Преступление и наказание',
                'YEAR' => 1866,
                'PAGES' => 672,
                'DESCRIPTION' => 'Психологический роман Достоевского',
                'PUBLISH_DATE' => '01.01.1866',
                'AUTHORS' => [2, 3] // Достоевский и Чехов
            ],
            [
                'TITLE' => 'Братья Карамазовы',
                'YEAR' => 1880,
                'PAGES' => 840,
                'DESCRIPTION' => 'Последний роман Достоевского',
                'PUBLISH_DATE' => '01.01.1880',
                'AUTHORS' => [2, 4] // Достоевский и Пушкин
            ],
            [
                'TITLE' => 'Евгений Онегин',
                'YEAR' => 1833,
                'PAGES' => 240,
                'DESCRIPTION' => 'Роман в стихах Пушкина',
                'PUBLISH_DATE' => '01.01.1833',
                'AUTHORS' => [4, 5] // Пушкин и Гоголь
            ],
            [
                'TITLE' => 'Мёртвые души',
                'YEAR' => 1842,
                'PAGES' => 352,
                'DESCRIPTION' => 'Поэма Гоголя',
                'PUBLISH_DATE' => '01.01.1842',
                'AUTHORS' => [5, 6] // Гоголь и Тургенев
            ],
            [
                'TITLE' => 'Отцы и дети',
                'YEAR' => 1862,
                'PAGES' => 288,
                'DESCRIPTION' => 'Роман Тургенева',
                'PUBLISH_DATE' => '01.01.1862',
                'AUTHORS' => [6, 7] // Тургенев и Булгаков
            ],
            [
                'TITLE' => 'Мастер и Маргарита',
                'YEAR' => 1967,
                'PAGES' => 384,
                'DESCRIPTION' => 'Роман Булгакова',
                'PUBLISH_DATE' => '01.01.1967',
                'AUTHORS' => [7, 1] // Булгаков и Толстой
            ],
            [
                'TITLE' => 'Сборник классических рассказов',
                'YEAR' => 1990,
                'PAGES' => 512,
                'DESCRIPTION' => 'Сборник лучших рассказов русских классиков',
                'PUBLISH_DATE' => '01.01.1990',
                'AUTHORS' => [1, 2, 3, 4, 5, 6, 7] // Все авторы
            ],
            [
                'TITLE' => 'Русская классика. Том 1',
                'YEAR' => 2000,
                'PAGES' => 768,
                'DESCRIPTION' => 'Антология русской классической литературы',
                'PUBLISH_DATE' => '01.01.2000',
                'AUTHORS' => [1, 3, 5] // Толстой, Чехов, Гоголь
            ],
            [
                'TITLE' => 'Русская классика. Том 2',
                'YEAR' => 2001,
                'PAGES' => 800,
                'DESCRIPTION' => 'Продолжение антологии русской классики',
                'PUBLISH_DATE' => '01.01.2001',
                'AUTHORS' => [2, 4, 6] // Достоевский, Пушкин, Тургенев
            ],
            [
                'TITLE' => 'Золотой век русской литературы',
                'YEAR' => 2010,
                'PAGES' => 1024,
                'DESCRIPTION' => 'Собрание сочинений великих русских писателей',
                'PUBLISH_DATE' => '01.01.2010',
                'AUTHORS' => [1, 2, 4, 5] // Толстой, Достоевский, Пушкин, Гоголь
            ],
            [
                'TITLE' => 'Серебряный век поэзии',
                'YEAR' => 2015,
                'PAGES' => 480,
                'DESCRIPTION' => 'Антология поэзии серебряного века',
                'PUBLISH_DATE' => '01.01.2015',
                'AUTHORS' => [4, 7] // Пушкин и Булгаков
            ],
            [
                'TITLE' => 'Великие романы',
                'YEAR' => 2018,
                'PAGES' => 1200,
                'DESCRIPTION' => 'Сборник великих русских романов',
                'PUBLISH_DATE' => '01.01.2018',
                'AUTHORS' => [1, 2, 6] // Толстой, Достоевский, Тургенев
            ],
            [
                'TITLE' => 'Классические повести',
                'YEAR' => 2020,
                'PAGES' => 640,
                'DESCRIPTION' => 'Сборник классических повестей',
                'PUBLISH_DATE' => '01.01.2020',
                'AUTHORS' => [3, 5, 7] // Чехов, Гоголь, Булгаков
            ]
        ];

        foreach ($books as $bookData) {
            $bookData['PUBLISH_DATE'] = DateTime::createFromText($bookData['PUBLISH_DATE']);
            $authorIds = $bookData['AUTHORS'];
            unset($bookData['AUTHORS']);

            $resultAdd = BookTable::add($bookData);
            if (!$resultAdd->isSuccess()) {
                throw new SystemException('Не удалось добавить тестовые данные: ' . implode(', ', $resultAdd->getErrorMessages()));
            }

            $bookId = $resultAdd->getId();
            $book = BookTable::getByPrimary($bookId)->fetchObject();

            if ($book) {
                foreach ($authorIds as $authorId) {
                    $author = AuthorTable::getByPrimary($authorId)->fetchObject();
                    if ($author) {
                        $book->addToAuthors($author);
                    }
                }
                $book->save();
            }
        }
    }
}
