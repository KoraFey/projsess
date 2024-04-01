package com.example.myapplication;

import android.content.Context;
import android.os.Build;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;

import java.util.List;

public class MarketAdapter extends ArrayAdapter<Market> {
    private List<Market> list;
    private Context context;
    private int viewRessourceId;
    public MarketAdapter(@NonNull Context context, int resource,@NonNull List<Market> list) {
        super(context, resource,list);
        this.list=list;
        this.viewRessourceId=resource;
        this.context=context;
    }

    @Override
    public int getCount(){
        return list.size();
    }

    @RequiresApi(api = Build.VERSION_CODES.O)
    public View getView(int position, View convertView, ViewGroup parent){
        View view=convertView;
        if(view==null){
            LayoutInflater layoutInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            view=layoutInflater.inflate(this.viewRessourceId,parent,false);
        }
        final Market post = this.list.get(position);
        if(post!=null){
            TextView username = view.findViewById(R.id.username);
            TextView time = view.findViewById(R.id.time);
            TextView description = view.findViewById(R.id.description);
            TextView titre = view.findViewById(R.id.titleMarket);
            Button notif = view.findViewById(R.id.notify);

            notif.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    //jsp koi faire
                }
            });

            username.setText(post.getUsername());
            time.setText(post.getTime());
            description.setText(post.getDescription());
            titre.setText(post.getTitre());

        }
        return view;

    }


}
