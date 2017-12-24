package com.creeps.sl_app.quizapp.view;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.Button;

import com.creeps.sl_app.quizapp.R;
import com.creeps.sl_app.quizapp.networking.RetrofitApiInterface;
import com.creeps.sl_app.quizapp.utilities.SharedPreferenceHandler;
import com.google.android.gms.auth.api.Auth;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.firebase.auth.FirebaseAuth;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.scalars.ScalarsConverterFactory;

/**
 * Created by ADMIN-PC on 20-12-2017.
 */

public class HelloWorldActivity extends AppCompatActivity
{
    Button mSignOut;


    public static Intent newIntent(Context context){
        Intent i=new Intent(context,HelloWorldActivity.class);
        return i;
    }
    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_hello);

        GoogleSignInOptions gso = new GoogleSignInOptions.Builder(GoogleSignInOptions.DEFAULT_SIGN_IN)
                .requestIdToken(getString(R.string.default_web_client_id))
                .requestEmail()
                .build();
        final GoogleApiClient googleApiClient = new GoogleApiClient.Builder(this)
                .addApi(Auth.GOOGLE_SIGN_IN_API, gso)
                .build();
        googleApiClient.connect();
        mSignOut = (Button) findViewById(R.id.signout);

        mSignOut.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View view)
            {



                FirebaseAuth auth = FirebaseAuth.getInstance();
                Log.d("HelloWorld","Status"+auth.getCurrentUser());
                auth.signOut();
                Log.d("HelloWorld","Status"+auth.getCurrentUser());

                Auth.GoogleSignInApi.signOut(googleApiClient);

            }
        });

        Retrofit retrofit = new Retrofit.Builder()
                .addConverterFactory(ScalarsConverterFactory.create())
                .baseUrl(getString(R.string.base_url))
                .build();

        RetrofitApiInterface service = retrofit.create(RetrofitApiInterface.class);
        SharedPreferenceHandler preferenceHandler = SharedPreferenceHandler.getInstance(this);
        String email = preferenceHandler.get("email");
        Log.i("email-id",email);
        Call<String> stringCall = service.getStringResponse(email);
        stringCall.enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                Log.i("RESP-BODY"," Hello "+ response.body() +" "+response.message()+" "+response.code());
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {
                Log.e("FAILURE", t.getMessage());
            }
        });
    }
}
