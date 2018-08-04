<nav id="column-left">
    <div id="navigation"><span class="fa fa-bars"></span> پنل مدیریت </div>
    <ul id="menu">
        <li id="menu-dashboard">

{{--        @can('permission','user.index-seller.index-userAdmin.index-role.index,permission.index')--}}
            <li id="menu-user">
                <a href="#collapse1" data-toggle="collapse" class="parent collapsed">
                   <img src="{{ asset('/image/icon/1.png') }}"> مدیریت کاربران و سطوح دسترسی
                </a>
                <ul id="collapse1" class="collapse">
{{--                    @can('permission','role.index-permission.index')--}}
                        <a href="#collapse1-1" data-toggle="collapse" class="parent collapsed">دسترسی ها
                        </a>
                        <ul id="collapse1-1" class="collapse">

{{--                            @can('permission','role.index')--}}
                                <li><a href="{{ route('role.index')}}">نقش های کاربری </a></li>
                            {{--@endcan--}}
{{--                            @can('permission','permission.index')--}}
                                    <li><a href="{{ route('permission.index')}}"> تنظیمات کاربری </a></li>
                            {{--@endcan--}}
                        </ul>
                    {{--@endcan--}}
{{--                    @can('permission','user.index')--}}
                        <li><a href="{{ route('admin.user.index')}}"> لیست کاربران عادی </a></li>
                    {{--@endcan--}}
                    {{--@can('permission','userAdmin.index')--}}
                        {{--<li><a href="{{ route('userAdmin.index')}}">لیست مدیران </a></li>--}}
                    {{--@endcan--}}
                    {{--@can('permission','seller.index')--}}
                        {{--<li><a href="{{ route('seller.index') }}">لیست  فروشندگان و تامین کنندگان </a></li>--}}
                    {{--@endcan--}}
                </ul>
            </li>
        {{--@endcan--}}

        {{--@can('permission','category.list-businessType.index')--}}
            {{--<li id="menu-category">--}}
                {{--<a href="#collapse2" data-toggle="collapse" class="parent collapsed">--}}
                    {{--<img src="{{ asset('/image/icon/2.png') }}">کسب و کارها </a>--}}
                {{--<ul id="collapse2" class="collapse">--}}
                    {{--@can('permission','category.list')<li><a href="{{route('category.list')}}">دسته بندی کسب و کار </a></li>@endcan--}}
                    {{--@can('permission','businessType.index')<li><a href="{{ route('businessType.index') }}">نوع کسب و کار </a></li>@endcan--}}
                {{--</ul>--}}
            {{--</li>--}}
        {{--@endcan--}}
























    </ul>




</nav>