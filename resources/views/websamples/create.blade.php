<form action="/admin/websamples" method="POST">
    
    {{ csrf_field() }}

    Title:<br>
    <input type="text" name="title" id="title">
    <br>
    Description:<br>
    <input type="text" name="description" id="description">
    <br>
    url:<br>
    <input type="text" name="url" id="url">
    <br>
    image:<br>
    <input type="text" name="image" id="image">
    <br>
    user_id:<br>
    <input type="text" name="user_id" id="user_id">
    <br>
    <br><br>
    <button type="submit">Submit</button>
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