<?php if (isset($this->aParams['sLongestPostAuthor']) && $this->aParams['sLongestPostAuthor'] != '') : ?>
    <?= $this->load('longestPost', $this->aParams);?>
<?php endif; ?>
<div class="postHolder post<?= $this->aParams['oPost']->getId(); ?>" data-id="<?= $this->aParams['oPost']->getId(); ?>"
        id="post<?= $this->aParams['oPost']->getId(); ?>" data-id="<?= $this->aParams['oPost']->getId(); ?>"
        data-date_created="<?= $this->aParams['oPost']->getDateCreated(); ?>">
    <div class="postContentHolder">
        <div class="actionsHolder">
            <a href="#" class="edit" onclick="return openEditForm(event, <?= $this->aParams['oPost']->getId(); ?>)">Edit</a>
            <a href="#" class="delete" onclick="return deletePost(event, <?= $this->aParams['oPost']->getId(); ?>)">Delete</a>
        </div>
        <h3 class="title"><?= $this->aParams['oPost']->getTitle(); ?></h3>
        <div class="body"><?= $this->aParams['oPost']->getContent(); ?></div>
        <div class="author">
            <span>Written by: </span>
            <span><?= $this->aParams['oPost']->getAuthor(); ?></span>
        </div>
    </div>
    <?php if (isset($this->aParams['iImagePosition']) && $this->aParams['iImagePosition'] == $this->aParams['iKey']) : ?>
        <div class="imageHolder">
            <img src="../Assets/Images/flyingElephant.png" />
        </div>
    <?php endif; ?>
</div>