/******头 文 件******/
#include<stdio.h>	//标准输入输出函数库
#include<time.h>	//用于获得随机数
#include<windows.h>	//控制dos界面
#include<stdlib.h>	//即 standard library 标志库头文件，里面定义了一些宏和通用工具函数
#include<conio.h>	//接受键盘输入输出

/******宏 定 义******/
#define U 1
#define D 2
#define L 3
#define R 4						//蛇的状态，U：上，D：下，L：左，R：右

/******定 义 全 局 变 量******/
typedef struct snake{	//蛇身的一个节点
	int x;	//节点的x坐标
	int y;	//节点的y坐标
	struct snake *next;	//蛇身的下一节点
}snake;
int score=0,add=10;	//总得分与每次吃食物得分
int HighScore;	//最高分
int status,sleeptime=200;	//蛇前进状态，每次运行的时间间隔
snake *head,*food;	//蛇头指针，食物指针
snake *q;	//遍历蛇的时候用到的指针
int endgamestatus=0;	//游戏结束的情况，1：撞到墙；2：咬到自己；3：主动退出游戏
HANDLE hOut;	//控制台句柄

/******函 数 声 明******/
void gotoxy(int x,int y);	//设置光标位置
int color(int c);	//更改文字颜色
void printsnake();	//字符画————蛇
void welcometogame();	//开始界面
void createMap();	//绘制地图
void scoreandtips();	//游戏界面右侧的得分和小提示
void initsnake();	//初始化蛇，画蛇身
void createfood();	//创建并随机出现食物
int biteself();	//判断是否咬到了自己
void cantcrosswall();	//设置蛇撞墙的情况
void speedup();	//加速
void speeddown();	//减速
void snakemove();	//控制蛇前进方向
void keyboardControl();	//控制键盘按键
void lostdraw();	//游戏结束界面
void endgame();	//游戏结束
void choose();	//游戏失败之后的选择
void File_out();	//在文件中读取最高分
void file_in();	//存储最高分进文件
void explation();	//游戏说明

/*文字颜色函数*/
int color(int c){
	SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE),c);
	return 0;
}

/*设置光标位置*/
void gotoxy(int x,int y){
	COORD c;
	c.X=x;
	c.Y=y;
	SetConsoleCursorPosition(GetStdHandle(STD_OUTPUT_HANDLE),c);
}

/*字符画————蛇*/
void printsnake(){
	gotoxy(35,1);
	color(6);
	printf("/^\\/^\\");	//蛇眼睛
	
	gotoxy(34,2);
	printf("|__|  O|");	//蛇眼睛
	
	gotoxy(33,2);
	color(2);
	printf("_");
	
	gotoxy(25,3);
	color(12);
	printf("\\/");	//蛇信
	
	gotoxy(31,3);
	color(2);
	printf("/");
	
	gotoxy(37,3);
	color(6);
	printf("\\_/");	//蛇眼睛
	
	gotoxy(41,3);
	color(10);
	printf("\\");
	
	gotoxy(26,4);
	color(12);
	printf("\\____");	//舌头
	
	gotoxy(32,4);
	printf("________/");
	
	gotoxy(31,4);
	color(2);
	printf("|");
	
	gotoxy(43,4);
	color(10);
	printf("\\");
	
	gotoxy(32,5);
	color(2);
	printf("\\_______");	//蛇嘴
	
	gotoxy(44,5);
	color(10);
	printf("\\");
	
	gotoxy(39,6);	//下面都是画蛇身
	printf("|     |	                 \\");
	
	gotoxy(38,7);
	printf("/      /                    \\");
	
	gotoxy(37,8);
	printf("/      /                     \\ \\");
	
	gotoxy(35,9);
	printf("/      /                        \\ \\");
	
	gotoxy(34,10);
	printf("/     /                           \\  \\");
	
	gotoxy(33,11);
	printf("/     /             _----_          \\   \\");
	
	gotoxy(32,12);
	printf("/     /           _-~      ~-_          |  |");
	
	gotoxy(31,13);
	printf("(     (        _-~     _--_     ~-_     _/  |");
	
	gotoxy(32,14);
	printf("\\    ~-____-~      _-~   ~-_     ~-_-~    /");
	
	gotoxy(33,15);
	printf("~-_           _-~           ~-_       _-~");
	
	gotoxy(35,16);
	printf("~--______-~                  ~-__-~");
}

/*开始界面*/
void welcometogame(){
	int n;
	int i,j=1;
	gotoxy(43,18);
	printf("贪 吃 蛇 游 戏");
	color(14);	//黄色边框
	for(i=20;i<=26;i++){	//输出下边框---
		for(j=27;j<=74;j++){	//输出左右边框|
			gotoxy(j,i);
			if(i==20 || i==26){
				printf("-");
			}else if(j==27 || j==74){
				printf("|");
			}
		}
	}
	color(12);
	gotoxy(35,22);
	printf("1.开始游戏");
	gotoxy(55,22);
	printf("2.游戏说明");
	gotoxy(35,24);
	printf("3.退出游戏");
	gotoxy(29,27);
	color(3);
	printf("请选择[1 2 3]:[]\b\b");	//\b为退格，使光标处于[]中间
	color(14);
	scanf("%d",&n);	//输入选项
	switch(n){	//3个选项
		case 1:	//选项1，还没有添加选项内容，之后添加
			system("cls");	//清屏
			createMap();	//创建地图
			initsnake();	//初始化蛇身
			createfood();	//添加新的语句
			scoreandtips();
		break;	
		case 2:	//选项2，还没有添加选项内容，之后添加
		
		break;	
		case 3:	//选项3，还没有添加选项内容，之后添加
			exit(0);	//退出程序
		break;
		default:	//输入非1~3的选项
			color(12);
			gotoxy(40,28);
			printf("请输入1~3之间的数！");
			getchar();	//输入任意键
			system("cls");	//清屏
			printsnake();
			welcometogame();
	}
}

/*创建地图*/
void createMap(){
	int i,j;
	for(i=0;i<58;i+=2){	//打印上下边框
		gotoxy(i,0);
		color(5);	//深紫色的边框
		printf("□");
		gotoxy(i,26);
		printf("□");
	}	
	for(i=0;i<26;i++){	//打印左右边框
		gotoxy(0,i);
		printf("□");
		gotoxy(56,i);
		printf("□");
	}
	for(i=2;i<56;i+=2){	//打印中间网格
		for(j=1;j<26;j++){
			gotoxy(i,j);
			color(3);
			printf("■\n\n");
		}
	}
	getchar();	//输入任意键
}

/*游戏界面右侧的得分和小提示*/
void scoreandtips(){
	File_out();	//调用File_out(),读取文件save.txt中的内容
	gotoxy(64,4);	//确定打印输出的位置
	color(11);	//设置颜色
	printf("☆最高纪录☆：%d",HighScore);	//打印游戏最高分
	gotoxy(64,8);
	color(14);
	printf("得分：%d ",score);
	color(13);
	gotoxy(73,11);
	printf("小 提 示");
	gotoxy(60,13);
	color(6);
	printf("╬ --------------------------- ╬");	//打印边框
	gotoxy(60,25);
	printf("╬ --------------------------- ╬");
	color(3);
	gotoxy(64,14);
	printf("每个食物得分：%d 分",add);
	gotoxy(64,16);
	printf("不能穿墙，不能咬到自己");
	gotoxy(64,18);
	printf("用↑↓←→分别控制蛇的移动");
	gotoxy(64,20);
	printf("F1 为加速，F2 为减速");
	gotoxy(64,22);
	printf("space：暂停游戏");	
	gotoxy(64,24);
	printf("ESC：退出游戏");
}

/*在文件中读取最高分*/
void File_out(){
	FILE *fp;
	fp=fopen("save.txt","a+");	//打开文件 save.txt
	fscanf(fp,"%d",&HighScore);	//把文件中的最高分读出来
	fclose(fp);	//关闭文件
}

/*初始化蛇，画蛇身*/
void initsnake(){
	snake *tail;
	int i;
	tail=(snake*)malloc(sizeof(snake));	//从蛇尾开始，头插法，以x,y设定开始的位置
	tail->x=24;	//蛇的初始位置(24,5)
	tail->y=5;
	tail->next=NULL;
	for(i=0;i<5;i++){	//设置蛇身，长度为5
		head=(snake*)malloc(sizeof(snake));	//初始化蛇头
		head->next=tail;	//蛇头的下一位置为蛇尾
		head->x=24+2*i;	//设置蛇头位置
		head->y=5;	
		tail=head;	//蛇头变成蛇尾，然后重复循环
	}
	while(tail!=NULL){	//从头到尾，输出蛇身
		gotoxy(tail->x,tail->y);
		color(14);
		printf("★");	//输出蛇身，蛇身用★组成
		tail=tail->next;	//蛇头输出完毕，输出蛇头的下一位，一直输出到蛇尾
	}
}

/*随机出现食物*/
void createfood(){
	snake *food_1;
	srand((unsigned)time(NULL));	//初始化随机数
	food_1=(snake*)malloc(sizeof(snake));	//初始化food_1
	//保证其为偶数，使得食物能与蛇头对其，然后食物会出现在网格线上
	food_1->x=1;
	while((food_1->x%2)!=0){
		food_1->x=rand()%52+2;	//设置食物的x坐标随机出现，食物的x坐标在2~53
	}
	food_1->y=rand()%24+1;	//食物的y在1~24
	q=head;
	while(q->next!=NULL){
		if(q->x==food_1->x && q->y==food_1->y){	//判断蛇身是否与食物重合
			free(food_1);
			createfood();
		}
		q=q->next;
	}
	
	gotoxy(food_1->x,food_1->y);	//设置食物的位置
	food=food_1;
	color(12);
	printf("●");	//输出食物
}

/*主函数*/
int main(){
	system("mode con cols=100 lines=30");	//设置控制台宽高
	printsnake();	//绘制字符蛇
	welcometogame();	//欢迎界面
	File_out();	//新添加的语句
	getchar(); 
}


















