<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        @foreach(request()->breadcrumbs()->segments() as $index => $segment)
        <li class="breadcrumb-item">
            <a href="{{$segment->url()}}">
                {{strtoupper(optional($segment->model())->title ?optional($segment->model())->title : $segment->name()) }}
            </a>
        </li>
        @endforeach
    </ol>
</nav>