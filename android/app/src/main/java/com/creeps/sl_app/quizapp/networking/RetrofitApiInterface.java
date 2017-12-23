package com.creeps.sl_app.quizapp.networking;

/**
 * Created by ADMIN-PC on 22-12-2017.
 */


import com.creeps.sl_app.quizapp.modal.Student;

import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.POST;

public interface RetrofitApiInterface {

    @FormUrlEncoded
    @POST("user-init.php")
    public Call<String> getStringResponse(@Field("email") String email);



}