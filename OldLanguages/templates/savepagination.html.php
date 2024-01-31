<form action="" method="post">
  <label for="pagination">Type name of controller to paginate:</label>
  <input id="pagination" name="pagination[controller_name]"><?= $pagination->controller_name ?? '' ?></input>
  <label for="pagination">Type number of records per page:</label>
  <input id="pagination" name="pagination[results]"><?= $pagination->results ?? '' ?></input>
  <input type="submit" name="submit" value="Save">
</form>