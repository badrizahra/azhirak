<nav id="column-left">
    <div id="navigation"><span class="fa fa-bars"></span> پنل مدیریت </div>
    <ul id="menu">
        <li id="menu-dashboard">

        <li id="menu-user">
            <a href="#collapse1" data-toggle="collapse" class="parent collapsed">
                <img src="{{ asset('/image/icon/1.png') }}"> مدیریت نمونه کارها
            </a>
            <ul id="collapse1" class="collapse">
                    <a href="#collapse1-1" data-toggle="collapse" class="parent collapsed">
                        نمونه کارهای وب
                    </a>
                    <ul id="collapse1-1" class="collapse">

                        <li><a href="{{ route('websamples.index') }}">لیست نمونه کارها </a></li>
                        <li><a href="{{ route('websamples.create') }}">درج نمونه کار </a></li>
                    </ul>
                <a href="#collapse1-2" data-toggle="collapse" class="parent collapsed">
                    نمونه کارهای شبکه
                </a>
                <ul id="collapse1-2" class="collapse">

                    <li><a href="{{ route('networksamples.index') }}">لیست نمونه کارها </a></li>
                    <li><a href="{{ route('networksamples.create') }}">درج نمونه کار </a></li>
                </ul>
                <a href="#collapse1-3" data-toggle="collapse" class="parent collapsed">
                    نمونه کارهای گرافیک
                </a>
                <ul id="collapse1-3" class="collapse">

                    <li><a href="{{ route('graphicsamples.index') }}">لیست نمونه کارها </a></li>
                    <li><a href="{{ route('graphicsamples.create') }}">درج نمونه کار </a></li>
                </ul>
            </ul>
        </li>
    </ul>
</nav>