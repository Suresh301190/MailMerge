<?php
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Input;

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

        private static $path = null;

        private static function getPath()
        {
            if ( null == self::$path ) {
                self::$path = storage_path() . '/' . User::getUID() . '/';
            }

            return self::$path;
        }

        /**
         * upload the file to the folder
         *
         * @return array $data['added', 'message']
         */
        public function scopeAddAttachment()
        {
            $data = array();
            if ( null == Input::file( 'file' ) ) {
                $data['added'] = false;
                $data['message'] = 'Invalid File';
            } else {
                $filename = Input::file( 'file' )->getClientOrigionalName();
                $extension = Input::file( 'file' )->getCLientOrigionalExtension();
                $data['added'] = Input::file( 'file' )->move( self::getPath(), "$filename.$extension" );
                if ( $data['added'] ) {
                    $data['message'] = "$filename.$extension Uploaded Successfully";
                } else {
                    $data['message'] = "$filename.$extension Upload Failed Please Try Again";
                }
            }

            return $data;
        }


        public static function getAttachments( $filenames )
        {
            $files = array();
            foreach($filenames as $filename){
                $filename["$filename"] = '';
            }
        }


    }