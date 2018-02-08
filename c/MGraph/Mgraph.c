//头文件及图的类型
#include<stdio.h>
#include<string.h>
#include<malloc.h>
#include<stdlib.h>
typedef char VertexType[4];
typedef char InfoPtr;
typedef int VRType;
#define INFINITY 65535	//65535被认为是一个无穷大的值
#define MaxSize 50	//顶点个数的最大值
typedef enum{DG,DN,UG,UN}GraphKind;	//图的类型：有向图、邮箱网、无向图和无向网
typedef struct{
	VRType adj;	//对于无权图，用1表示相邻，0表示不相邻；对于带权图，存储权值
	InfoPtr *info;	//与弧或边的相关信息
}ArcNode,AdjMatrix[MaxSize][MaxSize];
typedef struct{	//图的类型定义
	VertexType vex[MaxSize];	//用于存储顶点
	AdjMatrix arc;	//邻接矩阵，存储边或弧的信息
	int vexnum,arcnum;	//顶点数和边(弧)的数目
	GraphKind kind;	//图的类型
}MGraph;
void CreateGraph(MGraph *N);
int LocateVertex(MGraph N,VertexType v);
void DestroyGraph(MGraph *N);
void DisplayGraph(MGraph N);
void main(void){
	MGraph N;
	printf("创建一个网:\n");
	CreateGraph(&N);
	printf("输出网的顶点和弧:\n");
	DisplayGraph(N);
	printf("销毁网:\n");
	DestroyGraph(&N);
}
void CreateGraph(MGraph *N){	//采用邻接矩阵表示法创建有向网N
	int i,j,k,w;
	VertexType v1,v2;
	printf("请输入有向网N的顶点数,弧数:");
	scanf("%d,%d",&(*N).vexnum,&(*N).arcnum);
	printf("请输入%d个顶点的值(<%d个字符):\n",N->vexnum,MaxSize);
	for(i=0;i<N->vexnum;i++){	//创建一个数组,用于保存网的各个顶点
		scanf("%s",N->vex[i]);
	}
	for(i=0;i<N->vexnum;i++){	//初始化邻接矩阵
		for(j=0;j<N->vexnum;j++){
			N->arc[i][j].adj=INFINITY;
			N->arc[i][j].info=NULL;	//弧的信息初始化为空
		}
	}
	printf("请输入%d条弧的弧尾 弧头 权值(以空格作为间隔):\n",N->arcnum);
	for(k=0;k<N->arcnum;k++){
		scanf("%s%s%d",v1,v2,&w);	//输入两个顶点和弧的权值
		i=LocateVertex(*N,v1);
		j=LocateVertex(*N,v2);
		N->arc[i][j].adj=w;
	}
	N->kind=DN;
}
int LocateVertex(MGraph N,VertexType v){	//在顶点向量中查找顶点v,找到返回在向量的序号,否则返回-1
	int i;
	for(i=0;i<N.vexnum;++i){
		if(strcmp(N.vex[i],v)==0){
			return i;
		}
	}
	return -1;
}
void DestroyGraph(MGraph *N){	//销毁网
	int i,j;
	for(i=0;i<N->vexnum;i++){	//释放弧相关信息
		for(j=0;j<N->vexnum;j++){
			if(N->arc[i][j].adj!=INFINITY){	//如果存在弧
				if(N->arc[i][j].info!=NULL){	//如果弧有相关信息,释放该信息所占用空间
					free(N->arc[i][j].info);
					N->arc[i][j].info=NULL;
				}
			}
		}
	}
	N->vexnum=0;
	N->arcnum=0;
}
void DisplayGraph(MGraph N){	//输出邻接矩阵存储表示的图N
	int i,j;
	printf("有向网具有%d个顶点%d条弧,顶点依次是:",N.vexnum,N.arcnum);
	for(i=0;i<N.vexnum;++i){	//输出网的顶点
		printf("%s ",N.vex[i]);
	}
	printf("\n有向网N的:\n");
	printf("序号i=");
	for(i=0;i<N.vexnum;i++){
		printf("%8d",i);
	}
	printf("\n");
	for(i=0;i<N.vexnum;i++){
		printf("%8d",i);
		for(j=0;j<N.vexnum;j++){
			printf("%8d",N.arc[i][j].adj);
		}
		printf("\n");
	}
}






