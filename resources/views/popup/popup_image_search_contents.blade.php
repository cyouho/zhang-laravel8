<section class="jumbotron text-center">
    <div class="container mt-3">
        <form enctype="multipart/form-data">
            @csrf
            <input id="file-1" name="file" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="1" />
        </form>
    </div>
</section>