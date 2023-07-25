<body>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Inputs Data</h6>
                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="text" class="form-label">Title</label>
                            <input type="text" name="title"
                                class="form-control @error('title') is-invalid @enderror" id="text"
                                placeholder="Enter Title Name" value="{{ old('title') }}">

                            @error('title')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <input type="text" name="genre"
                                class="form-control @error('genre') is-invalid @enderror" id="genre"
                                placeholder="Enter Genre" value="{{ old('genre') }}">

                            @error('genre')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="time" class="form-label">Total Time</label>
                            <input type="number" name="time"
                                class="form-control @error('time') is-invalid @enderror" id="time"
                                placeholder="Enter time" value="{{ old('time') }}">

                            @error('time')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control @error('desc') is-invalid @enderror" name="desc" id="desc" rows="5">
                                {{ old('desc') }}</textarea>

                            @error('desc')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="formFile">Film Image</label>
                            <input class="form-control  @error('image') is-invalid @enderror" name="image"
                                type="file" id="formFile">

                            @error('image')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        CKEDITOR.replace('content');
    </script>
</body>
