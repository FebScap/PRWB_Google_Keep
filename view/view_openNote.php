<!DOCTYPE html>
<html>
    <head>
        <title>OpenNote</title>
        <?php include('head.html'); ?>
    </head>
    <body data-bs-theme="dark">
        <div class="d-flex bd-highlight mb-3">
            <div class="me-auto p-2 bd-highlight">
                <a type="button" href="viewnotes" class="btn btn-dark"><i class="bi bi-chevron-left"></i></div></a>
            <div class="p-2 bd-highlight">
                <button type="button" class="btn btn-dark"><i class="bi bi-share"></i></div></button>
            <div class="p-2 bd-highlight">
                <button type="button" class="btn btn-dark"><i class="bi bi-pin-fill"></i></div></button>
            <div class="p-2 bd-highlight">
                <button type="button" class="btn btn-dark"><i class="bi bi-arrow-down-square"></i></div></button>
            <div class="p-2 bd-highlight">
                <form action="deletenote/index" method="get"> 
                    <button type="submit" class="btn btn-dark"><i class="bi bi-pencil"></i></div></button>
                </form>
        </div>
          <?php include('footer.html'); ?>
    </body>
</html>