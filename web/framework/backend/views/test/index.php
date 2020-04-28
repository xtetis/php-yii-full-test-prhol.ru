<?php
    use yii\widgets\Pjax;

    $this->title = 'Список яблок';

    $this->registerJsFile(
        '@web/js/test.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    );
?>
<div class="test-index">
    <div class="test-index-content">

        <h1><?=$this->title?></h1>
        <div class="text-right">
            <a class="btn btn-default"
               id="btn__gen_apple"
               href="javascript:void(0);">Сгенерировать</a>
            <a class="btn btn-default"
               id="btn__del_all_apples"
               href="javascript:void(0);">Удалить все</a>
        </div>
        <br>
        <?php Pjax::begin(['id' => 'pjax_apples_container'])?>
        <div class="apple-list-container">
            <?php if ($apples): ?>
            <?php foreach ($apples as $apple): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Яблоко -
                    <?=date('d/m/Y H:i:s', $apple->create_date);?>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Парметр</th>
                                <th>Значение</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Цвет</td>
                                <td>
                                    <span class="label label-danger"
                                          style="background-color:<?=$apple->color?>">
                                        <?=$apple->color?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Дата появления</td>
                                <td> 
                                    <?=date('d/m/Y H:i:s', $apple->create_date);?>
                                    <br>
                                    (unixTmeStamp = <?=$apple->create_date?>)
                                </td>
                            </tr>
                            <tr>
                                <td>Состояние</td>
                                <td>
                                    <?=$apple::STATES_DESCRIPTION[$apple->state]?>
                                </td>
                            </tr>
                            <tr>
                                <td>Дата падения</td>
                                <td>
                                    <?=$apple->getFallingDateFormat();?>
                                    <?php if ($apple->falling_date): ?>
                                    <br>
                                    (unixTmeStamp = <?=$apple->falling_date;?>)
                                    <?php endif;?>
                                </td>
                            </tr>
                            <tr>
                                <td>Съедено (%)</td>
                                <td>
                                    <?=((100 - $apple->size));?>
                                </td>
                            </tr>
                            <tr>
                                <td>Процент от первоначальной массы (%)</td>
                                <td>
                                    <?=($apple->size);?>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <div>
                        <div class="btn-group"
                             role="group">
                            <button type="button"
                                    class="btn btn-default"
                                    id="btn__del_one_apple"
                                    idx="<?=$apple->apple_hash?>">Удалить</button>
                            <button type="button"
                                    class="btn btn-default"
                                    id="btn__modal_eat"
                                    idx="<?=$apple->apple_hash?>">Съесть</button>
                            <button type="button"
                                    class="btn btn-default"
                                    id="btn__fall_to_ground"
                                    idx="<?=$apple->apple_hash?>">Упасть на землю</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <?php else: ?>
            <div class="text-center">Яблоки еще не сгенерированы</div>
            <?php endif;?>
        </div>
        <?php Pjax::end()?>

    </div>
</div>




<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="modal_eat">
    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Съесть яблоко</h4>
            </div>
            <div class="modal-body">
                <form action=""
                      method="post"
                      id="form_eat">
                    <input type="hidden"
                           name="idx"
                           id="eat_idx">

                    <p>Укажите какой процент от яблока необходимо откусить</p>
                    <input type="range"
                           id="apple_slider"
                           value="0"
                           name="size_eat"
                           min="0"
                           max="100"
                           step="1" />
                    <br />
                    <div class="text-center">
                        <span id="apple_slider_value"></span> %
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-default"
                        data-dismiss="modal">Отмена</button>
                <button type="button"
                        class="btn btn-primary"
                        id="btn__send_eat">Откусить</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
