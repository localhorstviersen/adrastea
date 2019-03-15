{include file="header.tpl" title="Migration"}
<div class="container">
    <h1 class="mt-1">Migration</h1>

    {if $successful}
        <div class="alert alert-success" role="alert">
            Successful
        </div>
    {/if}
    {if $error}
        <div class="alert alert-danger" role="alert">
            Error: {$error}
        </div>
    {/if}

    <form method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Pin</label>
            <input type="password" required class="form-control" id="pin" name="pin" placeholder="Enter Pin">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
{include file="footer.tpl"}