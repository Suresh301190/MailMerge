<?php
    use Illuminate\Support\Facades\Input;

    /**
     * Created by PhpStorm.
     * User: Suresh
     * Date: 04-Dec-14
     * Time: 2:39 AM
     *
     * @property string id       references id on User Model
     * @property string filename file name of the attachment
     */
    class Attachment extends Eloquent
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
        public function addAttachment()
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
                    $attach = new Attachment();
                    $attach->id = User::getUID();
                    $attach->filename = "$filename.$extension";
                    $attach->save();
                } else {
                    $data['message'] = "$filename.$extension Upload Failed Please Try Again";
                }
            }

            return $data;
        }

        /**
         * Get the list of attachments which the user already saved
         *
         * @return array $filesKeyValue
         */
        public static function getAttachmentsArray()
        {
            if ( Cache::has( Attachment::getAttachmentListString() ) )
                return Cache::get( Attachment::getAttachmentListString() );

            $files = Attachment::select( array( 'filename' ) )
                ->where( 'id', '=', User::getUID() )
                ->get()
                ->toArray();

            $filesKeyValue = Helper::makeKeyValuePair( $files );

            Cache::put( Attachment::getAttachmentListString(), $filesKeyValue, 30 );

            return $filesKeyValue;
        }

        private static function getAttachmentListString()
        {
            return User::getUID() . '_AttachmentList';
        }


    }