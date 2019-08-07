<?php

class Constants {
    //project
    const ACTION = "action";
    const SUCCESS = "1";
    const FAILED = "0";
    const DEFAULT_JSON = "{}";

    //student
    const STUDENT_USER = "USERNAME";
    const STUDENT_PASS = "PASSWORD";

    //LDAP
    const NAME = "name";
    const SURNAME = "surname";

    //SRC MEMBER ACTIONS(DEFAULTS)
    const LOG_IN = "login";
    const UPDATE_PASS = "updatePass";

    //SRC MEMBER ACTION(ACTIVITY)
    const POST_ACTIVITY = "postActivity";
    const UPDATE_ACTIVITY = "updateActivity";
    const DELETE_ACTIVITY = "deleteActivity";
    const READ_ALL_ACTIVITIES = "readAllActivities";

    //SRC MEMBER ACTION(POLL)
    const POST_POLL = "postPoll";
    const DELETE_POLL = "deletePoll";
    const UPDATE_POLL = "updatePoll";
    const READ_ALL_POLLS = "readAllPolls";
    const POST_POLL_VOTE = "postPollVote";
    const DELETE_POLL_VOTE = "deletePollVote";
    

    //SRC POLL
    const SRC_POLL_TABLE = "SRC_POLL";
    const POLL_ID = "poll_id";
    const POLL_TITLE ="poll_title";
    const POLL_DESC = "poll_desc";
    const POLL_CHOICE="poll_choices";
    const POLL_DATE = "poll_date";
    const POLL_TIME = "poll_time";
    const POLL_TYPE = "poll_type";
    const POLL_SEL_CHOICE = "stud_selected_choice";
    const POLL_VOTE_TABLE = "STUD_POLL_VOTES";

    //SRC MEMBER_TABLE
    const SRC_MEMBER_TABLE = "SRC_MEMBER";
    const SRC_MEMBER_USER = "member_username";
    const SRC_MEMBER_PASS = "member_password";
    const SRC_MEMBER_NEW_PASS = "member_new_pass";

    //SRC ACTIVITIES
    const ACTIVITY_TABLE = "SRC_ACTIVITY";
    const ACTIVITY_ID = "activity_id";
    const ACTIVITY_TITLE = "activity_title";
    const ACTIVITY_DESC = "activity_desc";
    const ACTIVITY_DATE = "activity_date";
    const ACTIVITY_TIME = "activity_time";

    //ACTIVITIES LIKE AND DISLIKE
    const ACTIVITIES_LIKE_DISLIKE_TABLE = "STUD_LIKE_DISLIKE";
    const ACTIVITY_LIKE_DISLIKE = "activity_like_dislike";
    const STUD_LIKE_DISLIKE = "stud_like_dislike";
    const STUD_LIKE_DISLIKE_TABLE = "STUD_LIKE_DISLIKE";

    //ACTIVITIES COMMENTS
    const STUD_COMMENT_TABLE = "STUD_COMMENT";
    const STUDENT_USERNAME = "stud_username";
    const STUDENT_ID = "student_id"; //testing purpose
    const STUDENT_COMMENT = "stud_comment";
    const STUDENT_ANONYMITY = "stud_anonymity";
    const STUDENT_DATE = "stud_date";
    const STUDENT_TIME = "stud_time";

    //ACTIVITIES COMMENTS ACTIONS
    const POST_COMMENT = "postComment";
    const READ_COMMENT = "readComment";
    const POST_LIKE_OR_DISLIKE = "postLikeDislike";
    const GET_LD_STATUS = "LikeDislikeStatus";
    const POST_STATUS = "PostStatus";

    //POLL Actions
    const STUD_POLL_TABLE = "STUD_POLL_VOTES";

}
