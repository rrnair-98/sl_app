package com.creeps.sl_app.core_services.app.src.main.java.com.example.rohan.sl_app.networking;

import com.creeps.sl_app.core_services.modal.Student;
import com.example.rohan.sl_app.modal.Student;

import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.POST;

/**
 * Created by rohan on 30/9/17.
 *
 */

public interface RetrofitApiInterface {

    @FormUrlEncoded
    @POST("/quizapp/studentdetail.php")
    public Call<Student> getStudenInfo(@Field("username") String username, @Field("password") Long password, @Field("api_key") String apiKey);
    @FormUrlEncoded
    @POST("/quizapp/studentdetail.php")
    public Call<Student> getSomeDetails(@Field("user_id")Long userId,@Field("api_key") String apiKey);


}
