<form action="" method="post">
    <input type="hidden" name="pagination[id]" value="<?= $pagination->id ?? '' ?>">
    <label for="pagination">Name of controller to paginate:</label>
    <input id="pagination" name="pagination[controller_name]" value="<?= $pagination->controller_name ?? '' ?>"></input>
    <label for="pagination">Records per Page:</label>
    <input id="pagination" name="pagination[results]" value="<?= $pagination->results ?? '' ?>"></input>

    <input type="submit" name="submit" value="Save">
</form>