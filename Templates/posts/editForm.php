<form id="editForm<?= isset($this->aParams['oPost']) ? $this->aParams['oPost']->getId() : ''?>"
      class="editForm"
      name="editForm<?= isset($this->aParams['oPost']) ? $this->aParams['oPost']->getId() : ''?>"
      action="post"
      method="post"
      onsubmit="return savePost(event, <?= isset($this->aParams['oPost']) ? $this->aParams['oPost']->getId() : '0'?>)">
    <input type="hidden"
           name="id"
           class="postId"
           value="<?= isset($this->aParams['oPost']) ? $this->aParams['oPost']->getId() : '0'?>"/>
    <input type="text"
           name="author"
           placeholder="Author"
           value="<?= isset($this->aParams['oPost']) ? $this->aParams['oPost']->getAuthor() : ''?>"
           onclick="clearErrorMessages(<?= isset($this->aParams['oPost']) ? $this->aParams['oPost']->getId() : '0'?>)"/>
    <input type="text"
           placeholder="Title"
           name="title"
           value="<?= isset($this->aParams['oPost']) ? $this->aParams['oPost']->getTitle() : ''?>"
           onclick="clearErrorMessages(<?= isset($this->aParams['oPost']) ? $this->aParams['oPost']->getId() : '0'?>)" />
    <textarea name="content"
              placeholder="Content"
              onclick="clearErrorMessages(<?= isset($this->aParams['oPost']) ? $this->aParams['oPost']->getId() : '0'?>)" ><?= isset($this->aParams['oPost']) ? $this->aParams['oPost']->getContent() : ''?></textarea>
    <div id="responseBlock<?= isset($this->aParams['oPost']) ? $this->aParams['oPost']->getId() : ''?>"
         class="responseMessage error"
         style="display: none;">
        <span></span>
    </div>
    <?php if (isset($this->aParams['oPost']) && $this->aParams['oPost']->getId() > 0) : ?>
        <input type="button" name="close" value="Close" onclick="closeForm(<?= $this->aParams['oPost']->getId(); ?>)"/>
    <?php else : ?>
        <input type="button" name="clear" value="Clear" onclick="clearFormFields(this.parentNode)"/>
    <?php endif; ?>
    <input type="submit" name="submit" />
</form>