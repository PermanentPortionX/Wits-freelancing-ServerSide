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
}
