
<form enctype="multipart/form-data" action="/index.php?r=admin/category/test" method="POST">
  
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <br>
    <!-- Название элемента input определяет имя в массиве $_FILES -->
  
    Отправить этот файл: <input type="file" />  <br><br>
    <input type="submit" value="Отправить" />
</form>