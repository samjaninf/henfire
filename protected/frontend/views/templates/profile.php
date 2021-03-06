<?php

use yii\helpers\Html;
use common\components\MyHelpers;
use yii\authclient\widgets\AuthChoice;
use nirvana\prettyphoto\PrettyPhoto;
use kartik\widgets\StarRating;
//use imanilchaudhari\CurrencyConverter\CurrencyConverter;

$this->title = $model->full_name;
$curencysymbol = Symfony\Component\Intl\Intl::getCurrencyBundle()->getCurrencySymbol($mycurrency);
$profile_pic = $model->profile_picture;
if(empty($profile_pic))
{
	$profile_pic = 'assets/images/blank-person.jpg';
}
?>
<div class="container">
	<div class="profile-view">

            <div class="col-md-12 profile_header" <?= $style; ?>>
                <div class="<?= $profile_top; ?>">
                 <div class="star-rarting">
                <?php
                echo StarRating::widget(['name' => 'rating', 'value' => $model->rating,
                    'pluginOptions' => [
                        'displayOnly' => true,
                        'stars' => 5,
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,

                    ],
                ]);
                ?>
                </div>
                    <div class="col-md-2">
                        <div class="profile_picture" style="background-image:url('<?= $profile_pic; ?>')"></div>
                    </div>
                    <div class="col-md-3 profile_name <?= $textcolour; ?>">
                        <h2><?= $model->full_name; ?></h2>
                        <h4><?= $model->occupation; ?><h4>
                    </div>
                    <div class="col-md-4"><?= $add_cover; ?></div>
                    <div class="col-md-2 text-right profile_boost">

                        <?//= Html::a('Boost your sales', ['/promote'], ['class' => 'btn btn-warning']) ?>
                    </div>
                    <div class="col-md-1 text-right profile_update">
                        <?= Html::a(Yii::t('frontend', 'Update'), ['update'], ['class' => 'btn btn-default']) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="company_name">
                            "<?= $model->company_name; ?>"
                        </div>
                        <div class="introduction">
                        <?php
                        $introduction = $model->introduction;
                        if (strlen($introduction) > 147) {
                            $introduction = substr($introduction, 0, 147).' <a href="#" data-toggle="modal" data-target="#myModal" class="green">'.Yii::t('frontend', 'More...').'</a>';
                        }
                                ?>
                            <?= $introduction; ?>
                        </div>
                        <div class="hourlie_rate">
                            <span class="fa fa-fw fa-money green"></span> <?=$curencysymbol.' '.round($price); ?> /hr
                        </div>
                         <div class="available_now">
                            <?= $available_now; ?>
                        </div>
                        <div class="online_now">
                            <?= MyHelpers::isonline($model->id); ?>
                        </div>
                        <div class="profile_country">
                            <span class="fa fa-fw fa-map-marker"></span> <?= $model->city; ?>, <?= $model->country; ?>
                        </div>
                        <!--<div class="profile_heading">
                            <h5><strong><span class="fa fa-fw fa-circle-o"></span>FEATURED PROFILE</strong></h5>
                        </div>
                         <div class="profile_featured">
                            <div class="col-md-4">
                            	Status
                            </div>
                            <div class="col-md-8 text-right text-danger">
                            	<strong><span class="fa fa-fw fa-minus-circle"></span>NOT PROMOTING</strong>
                            </div>
                        </div>
                        <div class="promote_now text-center">
                        <p>Feature your profile and get 3x more leads.</p>
                        <a href="promote">promote now</a>
											</div>-->



                        <div class="profile_heading">
                            <h5><strong><span class="fa fa-fw fa-circle-o"></span><?=Yii::t('frontend', 'SKILLS');?></strong></h5>
                        </div>
                        <div class="tag_list">
                        <ul class="tags">
                        <?php $skills = $model->skills;
                              $splitted = explode(',', $skills);
                              $skills = json_decode(json_encode($splitted), true);
                            foreach ($skills as $value) {
                                echo '<li><a href="freelancer?FreelancerSearch[skills]='.$value.'" class="tag">'.$value.'</a></li>';
                            }
                        ?>
                        </ul>
                        </div>
                        <div class="profile_heading">
                            <h5><strong><span class="fa fa-fw fa-circle-o"></span><?=Yii::t('frontend', 'BUYER STATS');?></strong></h5>
                        </div>

                        	<div class="col-md-10 spaced">
														<?=Yii::t('frontend', 'Projects Completed');?>
                            </div>
                            <div class="col-md-1 text-right">
                            	<?= MyHelpers::projectscompleted($model->id); ?>
                            </div>

                        	<div class="col-md-10 spaced">
                            	<?=Yii::t('frontend', 'Sellers worked with');?>
                            </div>
                            <div class="col-md-1 text-right">

                            	<?= MyHelpers::hourliessales($model->id); ?>
                            </div>
                    </div>
                    <div class="col-md-9 nav-profile">
                        <ul class="nav nav-tabs nav-justified">
                          <li class=""><a data-toggle="tab" href="#home"><?=Yii::t('frontend', 'My Portfolio');?></a></li>
                          <li class="active"><a data-toggle="tab" href="#menu1"><?=Yii::t('frontend', 'My Hourlies');?></a></li>

                        </ul>

                        <div class="tab-content">
                          <div id="home" class="tab-pane fade in">
                          <?= MyHelpers::myPortFolio($model->portfolio); ?>
                           <?= PrettyPhoto::widget(); ?>
                          </div>
                          <div id="menu1" class="tab-pane fade in active">
                            <?= MyHelpers::MyHourlies($model->id, $curencysymbol); ?>
                          </div>
                        </div>
                    </div>
                </div>
             </div>
         </div>
    </div>
    <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?=Yii::t('frontend', 'About');?> <?= $model->full_name; ?></h4>
      </div>
      <div class="modal-body">
        <p><?= $model->introduction; ?></p>
      </div>
    </div>

  </div>
</div>
</div>
