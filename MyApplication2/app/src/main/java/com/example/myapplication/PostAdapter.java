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

public class PostAdapter extends ArrayAdapter<Post> {
    private Post[] list;

    private Comments[] comments;
    private CommentsAdapter commentsAdapter;
    private Context context;
    private int viewRessourceId;
    private MAIN main;
    private   OkHttpClient client;
    private boolean wasChecked;
    private  LinearLayoutManager manager;

    private horizonAdapter horizonAdapter;
    private MediaType JSON;

    public PostAdapter(@NonNull Context context, int resource,@NonNull Post[] list, MAIN main) {
        super(context, resource);
        this.list=list;
        this.context=context;
        this.viewRessourceId=resource;
        this.main=main;
        JSON = MediaType.parse("application/json; charset=utf-8");
        Collections.reverse(Arrays.asList(list));


    }

    @Override
    public int getCount(){
        return this.list.length;
    }
    @RequiresApi(api = Build.VERSION_CODES.O)
    public View getView(int position, View convertView, ViewGroup parent){

        View view=convertView;
        if(view==null){
            LayoutInflater layoutInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            view=layoutInflater.inflate(this.viewRessourceId,parent,false);
        }
        final Post post = this.list[position];
        if(post!=null){
            final ImageView icone = view.findViewById(R.id.iconeUser);
            final TextView username = view.findViewById(R.id.usernamePost);
            final TextView time = view.findViewById(R.id.timePostp);
            final RecyclerView content = view.findViewById(R.id.rec);
            final TextView caption = view.findViewById(R.id.textView6);
            final Button like = view.findViewById(R.id.button2);
            final Button      comment = view.findViewById(R.id.comments);
            final LinearLayout  lay = view.findViewById(R.id.laypos);
            ListView l = view.findViewById(R.id.comm);

            manager= new LinearLayoutManager(context,LinearLayoutManager.HORIZONTAL, false);

            horizonAdapter = new horizonAdapter(post.getUrl(),main);
            content.setLayoutManager(manager);
            content.setAdapter(horizonAdapter);

            if(post.getType().equals("annonce")){
                comment.setText("notifier vendeur");
                if(like !=null) {
                    lay.removeView(like);

                    final View memberView = main.getLayoutInflater().inflate(R.layout.prix_post_lay, null, false);
                    TextView prix = (TextView) memberView.findViewById(R.id.textView3);
                    prix.setText(String.valueOf(post.getPrix()) + "$");
                    lay.addView(memberView, 0);
                }





            }
            else{
                if(post.getLike()==1){
                    wasChecked=true;
                    like.setBackgroundColor(context.getColor(R.color.green));
                }
                else{
                    like.setBackgroundColor(context.getColor(R.color.grey));
                    wasChecked=false;
                }

                like.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        if(!(wasChecked)){

                            liked(true,post.getId());
                            wasChecked=true;
                            like.setBackgroundColor(context.getColor(R.color.green));

                        }
                        else{
                            liked(false,post.getId());
                            wasChecked=false;
                            like.setBackgroundColor(context.getColor(R.color.grey));
                        }

                    }
                });
            }
            comment.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    if(post.getType().equals("annonce")){
                        if(!(String.valueOf(post.getUser_id()).equals(main.getId()) )) {
                            sendMessage(post.getDescription().toString(),post.getUser_id());
                        }
                        else{
                            Toast.makeText(context,"vous etes le vendeur",Toast.LENGTH_SHORT).show();
                        }

                    }
                    else{



                        comments =  main.loadComment(post.getId());
                        if(comments.length>0) {
                            commentsAdapter = new CommentsAdapter(context, R.layout.message, comments);

                            l.setAdapter(commentsAdapter);
                            setListViewHeightBasedOnItems(l);
                            comments = new Comments[0];
                        }


                    }
                }
            });

            username.setText(post.getUsername());
            time.setText(post.getDate_publication());
            caption.setText(post.getDescription());


            //------------------------------






        }


        return view;
    }

     private void liked(boolean like, int id){

         client = new OkHttpClient();
         MediaType JSON = MediaType.parse("application/json; charset=utf-8");
         JSONObject obj = new JSONObject();

         try {
             if(like) {
                 obj.put("delete_ou_insert_comment", "insert");
             }
             else{
                 obj.put("delete_ou_insert_comment", "delete");
             }
             obj.put("publication_id",id);
         } catch (JSONException e) {
             throw new RuntimeException(e);
         }

         RequestBody corpsRequete = RequestBody.create(String.valueOf(obj), JSON);


         Request requete = new Request.Builder()
                 .url(API_URL + "/api/postLike")
                 .header("Authorization", "Bearer "+main.getToken())
                 .post(corpsRequete)
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
             }
         }).start();

     }


    private void sendMessage(String titre, int id){
        client = new OkHttpClient();
        JSONObject obj = new JSONObject();
        String s ="bonjour je suis" ;
        try{
            obj.put("user_id", id);
            obj.put("message", s);

        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        RequestBody body = RequestBody.create(String.valueOf(obj),JSON);

        Request requete = new Request.Builder()
                .url(API_URL + "/api/postMessagePrivate")
                .header("Authorization", "Bearer " + main.getToken())
                .post(body)
                .build();
        new Thread(new Runnable() {
            Response res;
            @Override
            public void run() {
                try {
                    res =client.newCall(requete).execute();
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }
                switch(res.code()){
                    case 200:
                        main.runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(main,String.valueOf(id),Toast.LENGTH_SHORT).show();
                            }
                        });



                        break;
                    case 500:
                        main.runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(main,"500",Toast.LENGTH_SHORT).show();
                            }
                        });
                        break;
                }
            }
        }).start();
    }

    public static boolean setListViewHeightBasedOnItems(ListView listView) {

        ListAdapter listAdapter = listView.getAdapter();
        if (listAdapter != null) {

            int numberOfItems = listAdapter.getCount();

            // Get total height of all items.
            int totalItemsHeight = 0;
            for (int itemPos = 0; itemPos < numberOfItems; itemPos++) {
                View item = listAdapter.getView(itemPos, null, listView);
                float px = 500 * (listView.getResources().getDisplayMetrics().density);
                item.measure(View.MeasureSpec.makeMeasureSpec((int) px, View.MeasureSpec.AT_MOST), View.MeasureSpec.makeMeasureSpec(0, View.MeasureSpec.UNSPECIFIED));
                totalItemsHeight += item.getMeasuredHeight();
            }

            // Get total height of all item dividers.
            int totalDividersHeight = listView.getDividerHeight() *
                    (numberOfItems - 1);
            // Get padding
            int totalPadding = listView.getPaddingTop() + listView.getPaddingBottom();

            // Set list height.
            ViewGroup.LayoutParams params = listView.getLayoutParams();
            params.height = totalItemsHeight + totalDividersHeight + totalPadding;
            listView.setLayoutParams(params);
            listView.requestLayout();
            //setDynamicHeight(listView);
            return true;

        } else {
            return false;
        }

    }


}
