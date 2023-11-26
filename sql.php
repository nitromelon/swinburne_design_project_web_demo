<?php

class SQL
{
    const login = "SELECT * FROM users WHERE username = :username AND password = :password";
    const login_information = "SELECT * FROM users WHERE user_id = :user_id";

    const courses_information = "SELECT * FROM courses WHERE course_id = :course_id";
    const courses = "SELECT * FROM courses LIMIT :offset, :limit";
    const courses_if_login = "SELECT * FROM courses WHERE course_id NOT IN (SELECT course_id FROM course_registration WHERE user_id = :user_id) LIMIT :offset, :limit";

    const course_registration = "SELECT * FROM course_registration WHERE user_id = :user_id AND course_id = :course_id";
    const course_registration_insert = "INSERT INTO course_registration (user_id, course_id, name, age, gender, living_location, bank, card_number, account_name) VALUES (:user_id, :course_id, :name, :age, :gender, :living_location, :bank, :card_number, :account_name)";

    const jobs = "SELECT jobs.job_id, jobs.title, jobs.salary, jobs.company_id, company.company_name FROM jobs INNER JOIN company ON jobs.company_id = company.company_id ORDER BY jobs.job_id DESC LIMIT :offset, :limit";
    const jobs_if_login = "SELECT jobs.job_id, jobs.title, jobs.salary, jobs.company_id, company.company_name FROM jobs INNER JOIN company ON jobs.company_id = company.company_id WHERE job_id NOT IN (SELECT job_id FROM job_application WHERE user_id = :user_id) ORDER BY jobs.job_id DESC  LIMIT :offset, :limit";

    // queries below are for search engine
    const jobs_salary_range = "SELECT MIN(salary) AS min, MAX(salary) AS max FROM jobs";
    const jobs_experience_requirement = "SELECT DISTINCT experience_requirement AS exp FROM jobs";
    const jobs_company_size = "SELECT DISTINCT size AS size FROM company";
    const jobs_working_format = "SELECT DISTINCT working_format AS format FROM jobs";
    const jobs_specialization = "SELECT DISTINCT specialization FROM jobs";
    // end of queries for search engine

    const job_detail = "SELECT jobs.*, company.* FROM jobs INNER JOIN company ON jobs.company_id = company.company_id WHERE job_id = :job_id";

    const job_application = "SELECT job_application.*, jobs.title FROM job_application INNER JOIN jobs ON job_application.job_id = jobs.job_id WHERE user_id = :user_id LIMIT :offset, :limit";
    const job_application_all = "SELECT * FROM job_application WHERE user_id = :user_id";
    const job_application_insert = "INSERT INTO job_application (user_id, job_id, resume_cv, statement, question, status) VALUES (:user_id, :job_id, :resume_cv, :statement, :question, 'applying')";
    const job_application_job_name = "SELECT title FROM jobs WHERE job_id = :job_id";

    const signup_check_exists = "SELECT * FROM users WHERE email = :email";
    const signup = "INSERT INTO users (username, password, email, phone, role) VALUES (:username, :password, :email, :phone, :role)";
    const signup_user_id = "SELECT user_id FROM users WHERE email = :email";

    const upload_job_user_in_company = "SELECT company_id FROM business_profile WHERE user_id = :user_id";
    const upload_job_get_company_name = "SELECT company_name FROM company WHERE company_id = :company_id";
    const upload_job = "INSERT INTO jobs (company_id, experience_requirement, working_format, specialization, title, benefits, salary, working_location, scope_of_work, employer, application_deadline) VALUES (:company_id, :experience_requirement, :working_format, :specialization, :title, :benefits, :salary, :working_location, :scope_of_work, :employer, DATE_ADD(NOW(), INTERVAL 30 DAY))";

    const course_paid = "SELECT course_registration.*, courses.title, courses.provider, courses.price, courses.category FROM course_registration INNER JOIN courses ON course_registration.course_id = courses.course_id WHERE user_id = :user_id";

    // queries below are for search engine in course
    const course_length = "SELECT MIN(length) AS min, MAX(length) AS max FROM courses";
    const course_provider = "SELECT DISTINCT provider FROM courses";
    const course_price = "SELECT MIN(price) AS min, MAX(price) AS max FROM courses";
    const course_category = "SELECT DISTINCT category FROM courses";
    // end of queries for search engine in course

    const upload_course = "INSERT INTO courses (title, introduction, length, outline, provider, benefit, price, category) VALUES (:title, :introduction, :length, :outline, :provider, :benefit, :price, :category)";
    /*
        ? Move this below query to under "course_registration_insert" in line 17.
    */
    const upload_course_get_course_id = "SELECT course_id FROM course_registration WHERE user_id = :user_id ORDER BY course_id DESC LIMIT 1";
    const upload_course_to_registered = "INSERT INTO registered_courses (user_id, course_id, enrollment_date, status) VALUES (:user_id, :course_id, NOW(), 'ongoing')";

    const registered_courses = "SELECT registered_courses.*, courses.title FROM registered_courses INNER JOIN courses ON registered_courses.course_id = courses.course_id WHERE user_id = :user_id";
    const registered_courses_with_course_id = "SELECT registered_courses.*, courses.title FROM registered_courses INNER JOIN courses ON registered_courses.course_id = courses.course_id WHERE user_id = :user_id AND registered_courses.course_id = :course_id";

    // bonus: review and rating
    const course_detail = "SELECT courses.*, review_and_rating.*, users.username
                            FROM courses
                            INNER JOIN review_and_rating ON courses.course_id = review_and_rating.course_id
                            INNER JOIN users ON review_and_rating.user_id = users.user_id
                            WHERE courses.course_id = :course_id";

    const interview = "SELECT * FROM interview 
                        INNER JOIN job_application 
                        ON interview.application_id = job_application.application_id 
                        WHERE job_application.user_id = :user_id";
    const interview_on_the_go = "SELECT * FROM interview_on_the_go WHERE application_id = :application_id";

    const search_engine_job = "SELECT * FROM jobs WHERE title = :title";
    const search_engine_course = "SELECT * FROM courses WHERE title = :title";
}
