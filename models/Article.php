<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $date
 * @property string $image
 * @property int $viewed
 * @property int $user_id
 * @property int $status
 * @property int $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    public static function getAll($pageSize = 5)
    {
        $query = Article::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $articles = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data['articles'] = $articles;
        $data['pagination'] = $pagination;
        return $data;
    }

    public static function getPopular()
    {
        return Article::find()->orderBy('viewed desc ')->limit(3)->all();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description', 'content'], 'string'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'number']
            /*
            [['description', 'content'], 'string'],
            [['date'], 'safe'],
            [['viewed', 'user_id', 'status', 'category_id'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            */
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Director',
            'year' => 'Year',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function getImage()
    {
        if ($this->image) {
            return '/uploads/' . $this->image;
        }
        return '/no-image.png';
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function deleteImage()
    {
        $imageUpModel = new ImageUpload();
        $imageUpModel->deleteCurrentImage($this->image);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id);

        if ($category != null) {
            $this->link('category', $category);
            return true;
        }
    }

    public function getSelectedTags()
    {
        $selectedTags = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedTags, 'id');
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function saveTags($tags)
    {
        if (is_array($tags)) {
            $this->clearCurrentTags();
            foreach ($tags as $tag_id) {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function clearCurrentTags()
    {
        ArticleTag::deleteAll(['article_id' => $this->id]);
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date);

    }

    public function saveArticle()
    {
        $this->user_id = Yii::$app->user->id;
        $this->date = date('Y-m-d');
        return $this->save(false);
    }

    public function getArticleComments()
    {
        return $this->getComments()->where(['status' => 1])->all();
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function viewedCounter()
    {
        $this->viewed += 1;
        return $this->save(false);
    }
}