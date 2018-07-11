<nav class="navbar-dark bg-black">
    <?php
    use Cake\Cache\Cache;
    use Vamshop\Core\Nav;

    $cacheKey = 'adminnav_' . $this->Layout->getRoleId() . '_' . $this->request->url . '_' . md5(serialize($this->request->query));
    echo Cache::remember($cacheKey, function () {
        return $this->Vamshop->adminMenus(Nav::items(), [
            'htmlAttributes' => [
                'id' => 'sidebar-menu',
            ],
        ]);
    }, 'croogo_menus');
    ?>
</nav>
