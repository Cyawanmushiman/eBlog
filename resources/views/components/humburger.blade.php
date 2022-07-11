<div id="navArea">
    <nav class="humburgerNav">
        <div class="inner">
            <a href="index.html" class="humburgerNav__title">eBlog</a>
            <ul class="menu">
                <li class="menu-item {{url()->current()==route('post.postList') ? 'active' : ''}}"><a
                        href="{{route('post.postList')}}">Home</a></li>
                <li class="menu-item {{url()->current()==route('contact.newContact') ? 'active' : ''}}"><a
                        href="{{route('contact.newContact')}}">Contact</a></li>
                <li class="menu-item {{url()->current() == route('about.aboutShow') ? 'active' : ''}}"><a
                        href="{{route('about.aboutShow')}}">About</a></li>
                @can('admin')
                <li class="menu-item {{url()->current()==route('post.newPost') ? 'active' : ''}}"><a
                        href="{{route('post.newPost')}}">New Post</a></li>
                @endcan
            </ul>
        </div>
    </nav>

    <div class="toggle_btn" id="btn17">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div id="mask"></div>
</div>
