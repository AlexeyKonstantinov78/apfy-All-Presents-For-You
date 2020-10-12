<?php foreach ($cats as $k=>$v): ?>
    <li style="margin-bottom: 10px">
        <label style="width: 50%; display: inline-block" for="nameCat_<?=$v['id']?>"><?=$v['name']?></label> <button type="button" class="btn btn-default" data-id="<?=$v['id']?>">Добавить/Изменить</button>
    </li>
<?php endforeach; ?>