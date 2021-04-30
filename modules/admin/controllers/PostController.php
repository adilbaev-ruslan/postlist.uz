<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Post;
use app\models\search\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Tag;
use app\models\TagAssign;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->title = json_encode($model->translate_title, JSON_UNESCAPED_UNICODE);
            $model->description = json_encode($model->translate_description, JSON_UNESCAPED_UNICODE);
            $model->content = json_encode($model->translate_content, JSON_UNESCAPED_UNICODE);

            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->image && $model->upload()) {
                $model->image = time() . '.' . $model->image->extension;
            }

            $model->save();
            
            if (isset($model->tag) and !empty($model->tag)) {
                $tags = explode(',',$model->tag);
                foreach ($tags as $tag) {
                    $check_tag = Tag::find()->where(['like', 'name', $tag])->one();
                    if($check_tag !== null){
                        $model2 = new TagAssign();
                        $model2->post_id = $model->id;
                        $model2->tag_id = $check_tag->id;
                        $model2->save(false);
                    }else{
                        $model3 = new Tag();
                        $model3->name = $tag;
                        $model3->save(false);

                        $model2 = new TagAssign();
                        $model2->post_id = $model->id;
                        $model2->tag_id = $model3->id;
                        $model2->save(false);
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $image = $model->image;

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->title = json_encode($model->translate_title, JSON_UNESCAPED_UNICODE);
            $model->description = json_encode($model->translate_description, JSON_UNESCAPED_UNICODE);
            $model->content = json_encode($model->translate_content, JSON_UNESCAPED_UNICODE);
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->image && $model->upload()) {
                $model->image = time() . '.' . $model->image->extension;
                if ($image) {
                    unlink(Yii::$app->basePath . '/web/uploads/' . $image);
                }
            }else {
                $model->image = $image;
            }
            $model->save();
            if (isset($model->tag) and !empty($model->tag)) {
                TagAssign::deleteAll(['post_id'=>$model->id]);
                $tags = explode(',',$model->tag);
                foreach ($tags as $tag) {
                    $check_tag = Tag::find()->where(['like', 'name', $tag])->one();
                    if($check_tag!==null){
                        $model2 = new TagAssign();
                        $model2->post_id = $model->id;
                        $model2->tag_id = $check_tag->id;
                        $model2->save(false);
                    }else{
                        $model3 = new Tag();
                        $model3->name = $tag;
                        $model3->save(false);

                        $model2 = new TagAssign();
                        $model2->post_id = $model->id;
                        $model2->tag_id = $model3->id;
                        $model2->save(false);
                    }
                }
            }else{
                TagAssign::deleteAll(['post_id'=>$model->id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->image) {
            unlink(Yii::$app->basePath . '/web/uploads/' . $model->image);
        }
        $model_tag_assign = new TagAssign();
        $model_tag_assign->deleteAll(['post_id' => $id]);
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
