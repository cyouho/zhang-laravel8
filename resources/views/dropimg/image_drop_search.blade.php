<section class="jumbotron text-center">
    <div class="container">
        <h1>以图搜图-拖拽上传功能</h1>
        <p class="lead text-muted">image search site-with drop function.</p>
    </div>
    <div class="container mt-3">
        <form enctype="multipart/form-data">
            @csrf
            <input id="file-1" name="file" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="1" />
        </form>
    </div>
</section>