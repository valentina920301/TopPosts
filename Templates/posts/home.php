<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Assets/Styles/styles.css">
    <script src="../Assets/JavaScript/Posts.js"></script>
    <title>Top Posts</title>
</head>
<body>
<div id="editFormTrigger" onclick="openEditFormMobile(this.nextElementSibling)"><span>+</span></div>
<div id="editFormHolder">
    <div class="label">Write new post: <span onclick="closeForm(0)">x</span></div>
    <?= $this->load('editForm');?>
</div>

<div id="contentHolder">

    <?php if (isset($this->aAllPosts)) : ?>
        <?php foreach ($this->aAllPosts as $iKey => $oPost) : ?>
            <?php $aData = array(
                'iKey' => $iKey,
                'oPost' => $oPost,
                'iImagePosition' => $this->iImagePosition,
            );
            $aData['sLongestPostAuthor'] = $iKey == 0 ? $this->sLongestPostAuthor : ""; ?>
            <?= $this->load('post', $aData);?>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
</body>
</html>