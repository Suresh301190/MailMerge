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
            $data = self::saveMailAttachment( '', 'file' );

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
         * @param string $file filename of the file to fetch from posted data save
         *
         * @return array $data['added', 'message', 'path', 'filename']
         */
        public static function saveMailAttachment( $dir, $file )
        {
            $data = array();
            if ( !Input::hasFile( "$file" ) ) {
                $data['added'] = false;
                $data['message'] = 'Invalid File';
            } else {
                $filename = Input::file( "$file" )->getClientOriginalName();
                $data['added'] = Input::file( "$file" )->move( self::getPath() . "/$dir", "$filename" );
                if ( $data['added'] ) {
                    $data['message'] = "$filename Uploaded Successfully";
                    $data['filename'] = "$filename";
                    $data['path'] = self::getPath() . "/$dir/$filename";
                } else {
                    $data['message'] = "$filename Upload Failed Please Try Again";
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

        /**
         * @param array|null $values if null returns all pre-defined
         *
         * @return array $attachmentsKeyValue
         */
        public static function getMailAttachmentsArray( $values = null )
        {
            // set pre-defined if no parameter is passed
            if ( !$values ) {
                $values = array_keys( self::getAttachmentsArray() );
            }
            $attachments = Attachment::select( array( 'fid', 'filename' ) )
                ->where( 'id', '=', User::getUID() )
                ->whereIn( 'fid', $values )
                ->get()
                ->toArray();

            $attachmentsKeyValue = array();


            foreach ( $attachments as $v ) {
                $attachmentsKeyValue[ $v['fid'] ] = $v['filename'];
            }

            return $attachmentsKeyValue;
        }

        /**
         * @param array $values to search for pre-defined and get the path corresponding to them
         *
         * @return array
         */
        public static function getMailAttachmentsPaths( $values )
        {
            $attachments = array();
            foreach ( Attachment::getMailAttachmentsArray( $values ) as $k => $v ) {
                array_push( $attachments, Attachment::getPath() . "/$v" );
            }

            return $attachments;
        }

    }