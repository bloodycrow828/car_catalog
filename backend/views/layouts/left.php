<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $userName ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Каталог', 'icon' => 'folder', 'items' => [
                        ['label' => 'Автомобили', 'icon' => 'file-o', 'url' => ['/catalog/car/index'], 'active' => $this->context->id == 'catalog/car'],
                        ['label' => 'Модели', 'icon' => 'file-o', 'url' => ['/catalog/category/index'], 'active' => $this->context->id == 'catalog/category'],
                    ]],

                    ['label' => 'Сервис', 'icon' => 'folder', 'items' => [
                        ['label' => 'Файловый менеджер', 'icon' => 'file-o', 'url' => ['/file/index'], 'active' => $this->context->id == 'file'],
                        ['label' => 'Пользователи', 'icon' => 'user', 'url' => ['/user/index'], 'active' => $this->context->id == 'user/index'],
                    ]],
                ],
            ]
        ) ?>

    </section>

</aside>
