<?php

    /**
     * Created by PhpStorm.
     * User: Suresh
     * Date: 04-Dec-14
     * Time: 2:39 AM
     *
     * @property string id        references id on User Model
     * @property enum   fid       file type of the document
     * @property string filename  file name of the attachment
     */
    class Attachment extends Eloquent
    {
        protected $table = 'attachments';

        public $timestamps = true;

        public $incrementing = false;

        private static $path = null;

        private static $attachmentsArray = array(
            'response' => 'Response Sheet',
            'brochure' => 'Brochure',
            'custom1'  => 'Custom1',
            'custom2'  => 'Custom2',
        );

        private static function getPath()
        {
            if ( null == self::$path ) {
                self::$path = storage_path() . '/' . User::getUID();
            }

            return self::$path;
        }

        public static function updateAttachment()
        {
            $data = self::saveMailAttachment( '', Input::file( 'file' ) );

            if ( $data['added'] ) {
                DB::table( 'attachments' )
                    ->where( 'id', '=', User::getUID() )
                    ->where( 'fid', '=', Input::get( 'type' ) )
                    ->update( array(
                        'filename' => $data['filename'],
                        'id'       => User::getUID(),
                        'fid'      => Input::get( 'type' ),
                    ) );
            }

            $data['attachmentList'] = Attachment::getAttachmentsArray();

            return View::make( 'dashboard.attach', $data );
        }

        /**
         * Upload the attachment to a folder for future as we use Mail::queue
         *
         * @param string $dir  directory slug for the mail attachment
         * @param array  $file file to save
         *
         * @return array $data['added', 'message', 'path', 'filename']
         */
        public function saveMailAttachment( $dir )
        {
            $data = array();
            if ( null == Input::file( 'file' ) ) {
                $data['added'] = false;
                $data['message'] = 'Invalid File';
            } else {
                $filename = Input::file( 'file' )->getClientOrigionalName();
                $extension = Input::file( 'file' )->getCLientOrigionalExtension();
                $data['added'] = Input::file( 'file' )->move( self::getPath() . "/$dir/", "$filename.$extension" );
                if ( $data['added'] ) {
                    $data['message'] = "$filename.$extension Uploaded Successfully";
                    $data['filename'] = "$filename.$extension";
                    $data['path'] = self::getPath() . "/$dir/$filename.$extension";
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
            return Attachment::$attachmentsArray;
        }

        private static function getAttachmentListString()
        {
            return User::getUID() . '_AttachmentList';
        }


    }