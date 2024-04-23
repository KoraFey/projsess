package com.example.myapplication;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import androidx.annotation.DrawableRes;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.squareup.picasso.Picasso;

import java.util.ArrayList;

public class horizonAdapter extends RecyclerView.Adapter<horizonAdapter.MyHolder> {
    private String[] data;
    private MAIN main;
    public horizonAdapter(String[] data,MAIN main) {
        super();
        this.data = data;
        this.main=main;

    }

    @NonNull
    @Override
    public MyHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View v = main.getLayoutInflater().inflate(R.layout.image_slide,parent,false);
        return new MyHolder(v);
    }

    @Override
    public void onBindViewHolder(@NonNull MyHolder holder, int position) {

        Picasso.get().load(data[position]).error(R.drawable.ic_info)
                .into(holder.v);
    }

    @Override
    public int getItemCount() {
        return data.length;
    }

    class MyHolder extends RecyclerView.ViewHolder{
        ImageView v;

        public MyHolder(@NonNull View itemView) {
            super(itemView);
            v = itemView.findViewById(R.id.contentpost2);
        }
    }
}
