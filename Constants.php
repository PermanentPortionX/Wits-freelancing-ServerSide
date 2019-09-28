<?php
header('Access-Control-Allow-Origin: *');
class Constants {
    //project
    const ACTION = "ACTION";

    const DEFAULT_JSON = "{}";
    const DEFAULT_JSON_ARRAY = "[]";
    const DATE_TIME_FORMAT = "d_m_Y_H:i";
    const TIME_FORMAT = "H:i";
    const DATE_FORMAT = "d/m/Y";

    //return codes
    const FAILED = 0;
    const SUCCESS = 1;
    const INSUFFICIENT_FUNDS = 2;
    const ALREADY_BID = 3;

    //student
    const STUDENT_USER = "USERNAME";
    const STUDENT_PASS = "PASSWORD";

    //LDAP
    const NAME = "name";
    const SURNAME = "surname";

    //ACTIONS
    const POST = 0;
    const VIEW_ALL = 1;
    const VIEW_SINGLE = 2;
    const ASSIGN_JOB = 3;
    const PAY = 4;
    const JOB_COMPLETE = 5;
    const VIEW_MY_JOBS = 6;
    const VIEW_MY_OFFERED_JOBS = 7;

    //business
    const TRANSACTION_FEE = 0.1;

    //Fund
    const FUND_TABLE = "WF_FUND";
    const FUND_STUD_ID = "FUND_STUD_ID";
    const FUND_AMOUNT = "FUND_AMOUNT";

    //WF_TRANSACTION
    const TRANSACTION_TABLE = "WF_TRANSACTION";
    const TRANSACTION_ID = "TRANSACTION_ID";
    const TRANSACTION_DATE_TIME = "TRANSACTION_DATE_TIME";
    const TRANSACTION_REASON = "TRANSACTION_REASON";
    const TRANSACTION_AMOUNT = "TRANSACTION_AMOUNT";

    //JOB
    const JOB_TABLE = "WF_JOB";
    const JOB_ID = "JOB_ID";
    const JOB_EMPLOYER_ID = "JOB_EMPLOYER_ID";
    const JOB_TITLE = "JOB_TITLE";
    const JOB_DESCRIPTION = "JOB_DESCRIPTION";
    const JOB_POST_DATE_TIME = "JOB_POST_DATE_TIME";
    const JOB_AMOUNT_RANGE_LOW = "JOB_AMOUNT_RANGE_LOW";
    const JOB_AMOUNT_RANGE_HIGH = "JOB_AMOUNT_RANGE_HIGH";
    const JOB_STATUS = "JOB_STATUS";
    const JOB_DUE_DATE_TIME = "JOB_DUE_DATE_TIME";
    const JOB_LOCATION = "JOB_LOCATION";
    const JOB_CATEGORY = "JOB_CATEGORY";
    const JOB_EMPLOYEE_ID = "JOB_EMPLOYEE_ID";

    //BID
    const BID_TABLE = "WF_BID";
    const BID_ID = "BID_ID";
    const BIDDER_ID = "BIDDER_ID";
    const BID_DATE_TIME = "BID_DATE_TIME";
    const BID_SUGGESTED_AMOUNT = "BID_SUGGESTED_AMOUNT";
    const BID_MESSAGE = "BID_MESSAGE";

    //COMPLAINTS
    const COMPLAINT_TABLE = "WF_COMPLAINTS";
    const COMPLAINT_ID = "COMPLAINT_ID";
    const COMPLAINT_TYPE = "COMPLAINT_TYPE";
    const COMPLAINT_DATE_TIME = "COMPLAINT_DATE_TIME";
    const COMPLAINT_MESSAGE = "COMPLAINT_MESSAGE";

    //JOB STATUS CODES
    const OPEN = 0;
    const ASSIGNED = 1;
    const COMPLETE = 2;
    const PAID = 3;

    /*SRC_APP*/
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
