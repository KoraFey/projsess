package com.example.myapplication;

import static com.example.myapplication.MainActivity.API_URL;

import android.content.Context;
import android.os.Build;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.DrawableRes;
import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatDelegate;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.squareup.picasso.Picasso;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.lang.reflect.Array;
import java.util.Arrays;
import java.util.Collections;

import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import okhttp3.ResponseBody;

public class PostAdapterLite extends ArrayAdapter<Post> {
    private Post[] list;

    private Comments[] comments;
    private CommentsAdapter commentsAdapter;
    private Context context;
    private int viewRessourceId;
    private boolean wasChecked;
    private LinearLayoutManager manager;
    private horizonAdapter horizonAdapter;
    private MediaType JSON;
    private Profile profile;

    public PostAdapterLite(@NonNull Context context, int resource, @NonNull Post[] list,Profile profile) {
        super(context, resource);
        this.list = list;
        this.context = context;
        this.viewRessourceId = resource;
        JSON = MediaType.parse("application/json; charset=utf-8");
        Collections.reverse(Arrays.asList(this.list));
        this.profile=profile;


    }

    @Override
    public int getCount() {
        return this.list.length;
    }

    @RequiresApi(api = Build.VERSION_CODES.O)
    public View getView(int position, View convertView, ViewGroup parent) {

        View view = convertView;
        if (view == null) {
            LayoutInflater layoutInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            view = layoutInflater.inflate(this.viewRessourceId, parent, false);
        }
        final Post post = this.list[position];
        if (post != null) {
            final ImageView icone = view.findViewById(R.id.iconeUser);
            final TextView username = view.findViewById(R.id.usernamePost);
            final TextView time = view.findViewById(R.id.timePostp);
            final ImageView content = view.findViewById(R.id.contentLite);
            final TextView caption = view.findViewById(R.id.textView6);
            final Button like = view.findViewById(R.id.button2);
            final Button comment = view.findViewById(R.id.comments);
            final LinearLayout lay = view.findViewById(R.id.laypos);
            final LinearLayout layP = view.findViewById(R.id.linearLayout);
            ListView l = view.findViewById(R.id.comm);
            Picasso.get().load(post.getUrl_pfp()).placeholder(R.drawable.ic_info).into(icone);

            Picasso.get()
                    .load(post.getUrl()[0]).placeholder(R.drawable.ic_info).into(content);            //
            if (true) {
                comment.setText("delete post");
                if (like != null) {

                    lay.removeView(like);

                }


            } else {


            }
            comment.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    delete(post.getId());
                }
            });

            username.setText(post.getUsername());
            time.setText(post.getDate_publication());
            caption.setText(post.getDescription());


            //------------------------------


        }


        return view;
    }

    public void delete(int id) {
        OkHttpClient client = new OkHttpClient();
        MediaType JSON = MediaType.parse("application/json; charset=utf-8");
        JSONObject obj = new JSONObject();

        try {
            obj.put("id_post", id);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }

        RequestBody corpsRequete = RequestBody.create(String.valueOf(obj), JSON);


        Request requete = new Request.Builder()
                .url(API_URL + "/api/posts/" + 0)
                .header("Authorization", "Bearer " + profile.getToken())
                .delete(corpsRequete)
                .build();
        new Thread(new Runnable() {
            @Override
            public void run() {
                Response response = null;
                try {
                    response = client.newCall(requete).execute();
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }
                if(response.code()==200) {
                    profile.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            Toast.makeText(context, "delete done", Toast.LENGTH_SHORT).show();
                            profile.loadPosts();
                        }
                    });
                }
            }
        }).start();

    }
}





