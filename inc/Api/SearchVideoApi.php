<?php
/**
 * Created by PhpStorm.
 * User: razor
 * Date: 2/6/2018
 * Time: 11:44 PM
 */

namespace inc\Api;


class SearchVideoApi
{
    private function find_native($video_block, $feed_item){

        $array_video_id = array(
            'query'     => $this->get_partner_feed_infos( $this->feed_infos->{$feed_item}->find->query ),
            'offset'    => $this->get_partner_feed_infos( $this->feed_infos->{$feed_item}->find->offset ),
            'attr'      => $this->get_partner_feed_infos( $this->feed_infos->{$feed_item}->find->attr )
        );

        if( $array_video_id['query'] != '' ){
            return $video_block->find( (string) $array_video_id['query'], (int) $array_video_id['offset'] )->{$array_video_id['attr']};
        }else{
            return $video_block->{$array_video_id['attr']};
        }
    }


    private function get_partner_feed_infos( $partner_feed_item ){
        $results = array();
        preg_match_all("/<%(.+)%>/U", $partner_feed_item, $results);

        foreach ( (array) $results[1] as $result) {
            if( strpos( $result, 'get_partner_option' ) !== false){
                $option                 = str_replace( array( 'get_partner_option("', '")'), array('', ''),  $result);
                $new_result             = '$saved_partner_options["' . $option . '"]';
                $partner_feed_item      = str_replace('<%' . $result . '%>', eval('return ' . $new_result . ';'), $partner_feed_item);
            }else{
                $partner_feed_item      = str_replace('<%' . $result . '%>', eval('return ' . $result . ';'), $partner_feed_item);
            }
        }

        return $partner_feed_item;
    }

    /*
    private function get_partner_existing_ids(){
        global $wpdb;

        $custom_post_type = xbox_get_field_value( 'amve-options', 'custom-video-post-type' );
        $custom_post_type = $custom_post_type != '' ? $custom_post_type : 'post';

        $query_str = "
            SELECT wposts.ID, wpostmetaVideoId.meta_value videoId
            FROM $wpdb->posts wposts, $wpdb->postmeta wpostmetasponsor, $wpdb->postmeta wpostmetaVideoId
            WHERE wposts.ID = wpostmetasponsor.post_id
            AND ( wpostmetasponsor.meta_key = 'partner' AND wpostmetasponsor.meta_value = %s )
            AND (wposts.ID =  wpostmetaVideoId.post_id AND wpostmetaVideoId.meta_key = 'video_id')
            AND wposts.post_type = %s
        ";

        $bdd_videos = $wpdb->get_results( $wpdb->prepare( $query_str, $this->params["partner"]['id'], $custom_post_type), OBJECT );

        $partner_videos_ids = array();

        foreach( (array)$bdd_videos as $bdd_video ){
            $partner_videos_ids[$bdd_video->ID] = $bdd_video->videoId;
        }

        unset( $bdd_videos );
        return $partner_videos_ids;
    }*/
}