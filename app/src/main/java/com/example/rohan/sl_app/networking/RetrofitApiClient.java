package com.example.rohan.sl_app.networking;

import android.content.Context;

import com.example.rohan.sl_app.R;

import retrofit2.Call;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

/**
 * Created by rohan on 30/9/17.
 * this class acts as a wrapper for the retrofit client. It has a factory method which requires Context( to prevent gcing) which returns an instance of the class.
 * The context is also used to obtain the BASE_URL from the string.xml file.
 * It has the following functions
 *  1. getRetrofit() returns the retrofit instancce
 *  2. getBaseURL() returns the BASE_URL which is specified in Resources/String file with id base_url
 */

public class RetrofitApiClient {
    private static RetrofitApiClient mRetrofitApiClient;
    private Context mContext;
    private final String BASE_URL;
    private final Retrofit mRetrofitInstance;

    /* Context is being takes as a param to prevent the object from getting gc'd. As long as a reference to the other object is alive and is in the young pool the other object can
    * not be gc'd hence the current wont be gcd*/
    private RetrofitApiClient(Context context){
        this.mContext=context;
        this.BASE_URL=this.mContext.getResources().getString(R.string.base_url);
        this.mRetrofitInstance= new Retrofit.Builder().baseUrl(this.BASE_URL).addConverterFactory(GsonConverterFactory.create()).build();

    }
    /* use this factory method to obtain an instance of the class*/
    public static RetrofitApiClient getInstance(Context context){
        if(RetrofitApiClient.mRetrofitApiClient==null){
            RetrofitApiClient.mRetrofitApiClient = new RetrofitApiClient(context);
        }
        return RetrofitApiClient.mRetrofitApiClient;
    }


    public String getBaseUrl() {
        return this.BASE_URL;
    }

    public void getUserDetails(){

    }



}
