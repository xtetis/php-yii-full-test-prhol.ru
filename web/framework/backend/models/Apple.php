<?php
namespace backend\models;

use Yii;

class Apple
{
    const ON_THE_TREE         = 0;
    const ON_GROUND           = 1;
    const ROTTEN              = 2;
    const APPLE_NOT_FALLS_YET = 'Яблоко еще не упало';

    const STATES_DESCRIPTION = [
        0 => 'На дереве',
        1 => 'Упало на землю',
        2 => 'Гнилое',
    ];

    /**
     * цвет (устанавливается при создании объекта случайным)
     */
    public $color;

    /**
     * Идентификтор яблока
     */
    public $apple_hash = '';

    /**
     * дата появления (устанавливается при создании объекта случайным unixTmeStamp)
     */
    public $create_date;

    /**
     * Состояния (висит на дереве, упало/лежит на земле,гнилое яблоко)
     */
    protected $state = 0;

    /**
     * дата падения (устанавливается при падении объекта с дерева)
     */
    public $falling_date = 0;

    /**
     * сколько съели (%)
     */
    public $size = 100;

    public function __construct()
    {
        $this->create_date = $this->getRandomUnixTime();
        $this->color       = $this->getRandomColor();
        $this->state       = Apple::ON_THE_TREE;
        $this->apple_hash  = uniqid();

        $_SESSION['apples'] = $_SESSION['apples'] ?? [];
        $_SESSION['apples'][$this->apple_hash] = $this;
    }

    /**
     * Генерируем рандомную дату
     */
    protected function getRandomUnixTime()
    {
        $date_start = strtotime('-1 day');
        $date_end   = strtotime('now');

        return rand($date_start, $date_end);
    }

    /**
     * Генерируем рандомный цвет
     */
    protected function getRandomColor()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    /**
     * Упасть на землю
     */
    public function fallToGround()
    {
        if (Apple::ON_GROUND == $this->state)
        {
            throw new \yii\web\HttpException(400, 'Яблоко уже упало');
        }

        $this->state = Apple::ON_GROUND;

        $this->falling_date = strtotime('now');
    }

    /**
     * Возвращетвремя падения на демлю
     */
    public function getFallingDateFormat()
    {
        if ($this->falling_date)
        {
            return date('d/m/Y H:i:s', $this->falling_date);
        }

        return Apple::APPLE_NOT_FALLS_YET;
    }

    /**
     * Возвращетвремя падения на демлю
     */
    public function eat($size_eat)
    {

        if (Apple::ON_THE_TREE == $this->state)
        {
            throw new \yii\web\HttpException(400, 'Нельзя кусать яблоко на дереве');
        }

        if (Apple::ROTTEN == $this->state)
        {
            throw new \yii\web\HttpException(400, 'Нельзя кусать гнилое яблоко');
        }

        if ($this->size - $size_eat < 0)
        {
            throw new \yii\web\HttpException(400, 'Нельзя откусить более чем ' . $this->size);
        }

        if (0 == $size_eat)
        {
            throw new \yii\web\HttpException(200, 'Откусите больше чем 0');
        }

        $this->size -= $size_eat;

        $this->checkIfEmpty();
    }

    /**
     * В случае получения состояния, если яблоко пролежало уже 5 часов на
     * земле - присвааиваем статус "Испорчено"
     */
    public function __get($property)
    {
        if (property_exists($this, $property))
        {
            if (('state' == $property) && (Apple::ON_GROUND == $this->state))
            {

                $now               = strtotime('now');
                $falling_date_five = strtotime('+5 hours', $this->falling_date);
                if ($now > $falling_date_five)
                {
                    $this->state = Apple::ROTTEN;
                }

            }

            return $this->$property;
        }

    }


    /**
     * Проверяет съедено ли яблоко полностью,если да - удаляемданныео яблоке
     */
    protected function checkIfEmpty()
    {
        if (!$this->size)
        {
            $this->delete();
        }
    }




    /**
     * Возвращает яблоко
     */
    public static function getOne($apple_hash)
    {
        if (!isset($_SESSION['apples'][$apple_hash]))
        {
            throw new \yii\web\HttpException(400, 'Такого яблока не существует');
        }
        
        return $_SESSION['apples'][$apple_hash];
    }

    /**
     * Удаляем яблоко
     */
    public function delete()
    {
        if(isset($_SESSION['apples'][$this->apple_hash]))
        {
            unset($_SESSION['apples'][$this->apple_hash]);
        }
    }

    /**
     * Удаляем все яблоки
     */
    public static function deleteAll()
    {
        if(isset($_SESSION['apples']))
        {
            unset($_SESSION['apples']);
        }
    }

    /**
     * Удаляем все яблоки
     */
    public static function getAll()
    {
        return $_SESSION['apples'] ?? [];
    }

}
