<?php
    use Illuminate\Database\Eloquent\Model;

    /**
     * Created by PhpStorm.
     * User: Suresh
     * Date: 04-Dec-14
     * Time: 2:39 AM
     */
    class Attachment extends Model
    {
        protected $table = 'attachments';

        public $timestamps = true;

        public $incrementing = false;
    }