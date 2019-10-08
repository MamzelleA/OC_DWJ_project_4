<?php $this->title = 'Chapitres';?>
<div class="row">
	<div class="col-sm-12">
		 <h2 class="text-center h2-title-top" ><span class="font-weight-bold">LES </span><?= strtoupper($this->title) ?></h2>
	</div>
</div>
<div class="row">
<?php foreach($list as $chap):
	$extract = substr($chap['content_chap'], 0, 800);
	$lastSpace = strrpos($extract, ' '); //avoid to cut a word
	$extract = substr($extract,0,$lastSpace)." [...]";
?>
	<div class="col-sm-12 border-bottom border-left border-1 border-light my-3">
		<div class="button bg-transparent px-3" data-toggle="collapse" role="button" href="#num-<?= $chap['num_chap'] ?>" aria-expanded="false" aria-controls="author-resume" title="cliquez pour lire un extrait">
			<div class="float-right mb-1"><?php if (isset($_COOKIE['numLastChap'])){if($chap['num_chap'] == $_COOKIE['numLastChap']){echo '<i class="fas fa-bookmark"></i>';}} ?></div>
			<h4 class="pt-1">Chapitre <?php echo $chap['num_chap'] ?></h4>
			<h3><?php echo $chap['title_chap'] ?></h3>
		</div>
		<div class="collapse" id="num-<?= $chap['num_chap'] ?>">
			<p class="text-justify px-3"><?= $extract ?></p>
			<div class="float-right p-3"><a title="lire le chapitre" href=<?="index.php?action=chapter&num=" .$chap['num_chap']?>><i class="fas fa-plus-circle"></i></a></div>
		</div>
	</div>
<?php endforeach; ?>
</div>
