package com.creeps.sl_app.quizapp.utilities;

/**
 * Created by ADMIN-PC on 22-12-2017.
 */

import android.content.Context;
import android.content.SharedPreferences;



public class SharedPreferenceHandler {
    private Context mContext;
    private static SharedPreferenceHandler mSharedPreferenceHandler;/* to be used for singleton*/
    private final SharedPreferences sharedPreferences;/* to be used for persisting essential data across sessions*/
    private final String SHARED_PREF_NAME="Sl_pref";/* name of the sharePref file*/

    private SharedPreferenceHandler(Context context){
        this.mContext=context;
        this.sharedPreferences=context.getSharedPreferences(SHARED_PREF_NAME,Context.MODE_PRIVATE);
    }



    public static SharedPreferenceHandler getInstance(Context context){
        if(SharedPreferenceHandler.mSharedPreferenceHandler == null){
            SharedPreferenceHandler.mSharedPreferenceHandler = new SharedPreferenceHandler(context);
        }

        return SharedPreferenceHandler.mSharedPreferenceHandler;
    }

    public String get(String x){
        return this.sharedPreferences.getString(x,null);
    }
    public void add(String key,String value){
        SharedPreferences.Editor editor=this.sharedPreferences.edit();
        editor.putString(key,value);
        editor.apply();/* commit asynchronously*/
    }




}
