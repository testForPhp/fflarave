<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::guard('admin')->user()->username }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>

    <li class="{{ isset($menuActive['home']) ? $menuActive['home'] : '' }}">
        <a href="{{ $webPath }}/index">
            <i class="fa fa-dashboard"></i> <span>Home</span>
        </a>
    </li>
    <li class="treeview {{ isset($menuActive['system']) ? $menuActive['system'] : '' }}">
        <a href="#">
            <i class="fa fa-gears"></i> <span>System Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ isset($serverMenu) ? $serverMenu : '' }}">
                <a href="{{ $webPath }}/system/server"><i class="fa fa-circle-o {{ isset($serverMenu) ? 'text-aqua' : '' }}"></i>伺服器</a>
            </li>
            <li class="{{ isset($settingMenu) ? $settingMenu : '' }}">
                <a href="{{ $webPath }}/system/setting"><i class="fa fa-circle-o {{ isset($settingMenu) ? 'text-aqua' : '' }}"></i>系統設置</a>
            </li>
            <li class="{{ isset($notifyMenu) ? $notifyMenu : '' }}">
                <a href="{{ $webPath }}/system/notify"><i class="fa fa-circle-o {{ isset($notifyMenu) ? 'text-aqua' : '' }}"></i>通知</a>
            </li>
        </ul>
    </li>
    <li class="treeview {{ isset($menuActive['videoMenu']) ? $menuActive['videoMenu'] : '' }}">
        <a href="#">
            <i class="fa fa-video-camera"></i>
            <span>視頻管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ isset($activeVideoMenu) ? $activeVideoMenu : '' }}">
                <a href="{{ $webPath }}/video/1"><i class="fa fa-circle-o {{ (isset($activeVideoMenu) && $activeVideoMenu == 'active') ? 'text-aqua' : '' }}"></i>列表</a>
            </li>
            <li class="{{ isset($createVideoMenu) ? $createVideoMenu : '' }}">
                <a href="{{ $webPath }}/video/create"><i class="fa fa-circle-o {{ isset($createVideoMenu) ? 'text-aqua' : '' }}"></i>添加</a>
            </li>
            <li class="{{ isset($haltVideoMenu) ? $haltVideoMenu : '' }}">
                <a href="{{ $webPath }}/video/0"><i class="fa fa-circle-o {{ (isset($haltVideoMenu) && $haltVideoMenu == 'active') ? 'text-aqua' : '' }}"></i>待審核</a>
            </li>
            <li class="{{ isset($videoSort) ? $videoSort : '' }}">
                <a href="{{ $webPath }}/video/sort"><i class="fa fa-circle-o {{ isset($videoSort) ? 'text-aqua' : '' }}"></i>分類</a>
            </li><li class="{{ isset($videoTagMenu) ? $videoTagMenu : '' }}">
                <a href="{{ $webPath }}/video/tags"><i class="fa fa-circle-o {{ isset($videoTagMenu) ? 'text-aqua' : '' }}"></i>標籤</a>
            </li>
            </li><li class="{{ isset($importMenu) ? $importMenu : '' }}">
                <a href="{{ $webPath }}/video/import"><i class="fa fa-circle-o {{ isset($importMenu) ? 'text-aqua' : '' }}"></i>上传</a>
            </li>
        </ul>
    </li>

    <li class="treeview {{ isset($menuActive['finance']) ? $menuActive['finance'] : '' }}">
        <a href="#">
            <i class="fa fa-credit-card"></i> <span>財務信息</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="@if(isset($programMenu)){{ $programMenu }}@endif"><a href="{{ $webPath }}/program">
                    <i class="fa fa-circle-o {{ isset($programMenu) ? 'text-aqua' : '' }}"></i>觀看方案</a>
            </li>

        </ul>
    </li>

    <li class="treeview {{ isset($menuActive['point']) ? $menuActive['point'] : '' }}">
        <a href="#">
            <i class="fa fa-cc-diners-club"></i> <span>充值點數</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="@if(isset($pointMenu)){{ $pointMenu }}@endif"><a href="{{ $webPath }}/point"><i class="fa fa-circle-o {{ isset($pointMenu) ? 'text-aqua' : '' }}"></i>點數套餐</a></li>
            <li class="@if(isset($payCodeActiveMenu)){{ $payCodeActiveMenu }}@endif"><a href="{{ $webPath }}/pay-code/1/0"><i class="fa fa-circle-o {{ isset($payCodeActiveMenu) ? 'text-aqua' : '' }}"></i>支付嗎(已使用)</a></li>
        </ul>
    </li>

    <li class="treeview {{ isset($menuActive['user']) ? $menuActive['user'] : '' }}">
        <a href="#">
            <i class="fa fa-group"></i> <span>用戶管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ isset($userListMenu) ? $userListMenu : '' }}">
                <a href="{{ $webPath }}/user"><i class="fa fa-circle-o {{ isset($serverMenu) ? 'text-aqua' : '' }}"></i>用戶列表</a>
            </li>
        </ul>
    </li>

    <li class="{{ isset($menuActive['links']) ? $menuActive['links'] : '' }}">
        <a href="{{ $webPath }}/links">
            <i class="fa fa-unlink"></i> <span>Links</span>
        </a>
    </li>
    <li class="{{ isset($menuActive['reflect']) ? $menuActive['reflect'] : '' }}">
        <a href="{{ $webPath }}/reflect">
            <i class="fa fa-bell"></i> <span>檢舉</span>
        </a>
    </li>
</ul>
    </section>
    <!-- /.sidebar -->
</aside>