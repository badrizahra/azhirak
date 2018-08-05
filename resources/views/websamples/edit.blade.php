<form action="/admin/websamples/{{ $webSample->id }}" method="POST">
    
    {{ csrf_field() }}
    
    {{ method_field('PUT') }}

    Title:<br>
    <input type="text" name="title" id="title" value="{{ $webSample['title'] }}">
    <br>
    Description:<br>
    <input type="text" name="description" id="description" value="{{ $webSample['description'] }}">
    <br>
    url:<br>
    <input type="text" name="url" id="url" value="{{ $webSample['url'] }}">
    <br>
    image:<br>
    <input type="text" name="image" id="image" value="{{ $webSample['image'] }}">
    <br>
    user_id:<br>
    <input type="text" name="user_id" id="user_id" value="{{ $webSample['user_id'] }}">
    <br>
    <br><br>
    <button type="submit">Submit</button>
</form>

<form action="/admin/websamples/{{ $webSample->id }}" method="POST">
    
    {{ csrf_field() }}
    
    {{ method_field('DELETE') }}

    Delete:<br>
    <button type="submit">Delete</button>

</form>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif