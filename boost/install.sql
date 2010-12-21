-- skeleton - phpwebsite module
-- @version $Id: $
-- @author Verdon Vaillancourt <verdonv at gmail dot com>

BEGIN;
CREATE TABLE golfer_golfer (
    id              int not null default 0,
    name            varchar(255) not null,
    current_handicap float,
    update_date     int,
    PRIMARY KEY     (id)
);

CREATE TABLE golfer_score (
    id              int not null default 0,
    golfer_id       int not null default 0,
    created_date    int not null,
    course_name     varchar(255),
    course_rating   int not null,
    slope           int not null,
    note            text default null,
    score           int not null,
    PRIMARY KEY (id),
    index (golfer_id)
);
COMMIT;
