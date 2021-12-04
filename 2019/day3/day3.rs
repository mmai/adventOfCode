use std::fs;
use std::collections::BinaryHeap;
use std::cmp::Ordering;

#[derive(Debug)]
struct Move <'s>{
    direction: &'s str,
    distance: i32,
}

fn new_move(stmove: &str) -> Move {
    let direction = &stmove[0..1];
    let distance: i32 = (&stmove[1..]).parse().unwrap();
    Move { direction:direction, distance:distance }
}

#[derive(Debug, Clone, PartialEq, Eq)]
struct Point {
    x: i32,
    y: i32,
    steps: i32,
}

impl Ord for Point {
    fn cmp(&self, other: &Self) -> Ordering {
        let d1 = &self.distance();
        let d2 = &other.distance();
        d2.cmp(d1)
    }
}

impl PartialOrd for Point {
    fn partial_cmp(&self, other: &Self) -> Option<Ordering> {
        Some(self.cmp(other))
    }
}

impl Point {
    pub fn distance(self: &Point) -> i32 {
        self.x.abs() + self.y.abs()
    }
    pub fn moveRight(self: &mut Point, dist: i32){
        self.x = self.x + dist;
        self.steps = self.steps + dist;
    }
    pub fn moveLeft(self: &mut Point, dist: i32){
        self.x = self.x - dist;
        self.steps = self.steps + dist;
    }
    pub fn moveUp(self: &mut Point, dist: i32){
        self.y = self.y + dist;
        self.steps = self.steps + dist;
    }
    pub fn moveDown(self: &mut Point, dist: i32){
        self.y = self.y - dist;
        self.steps = self.steps + dist;
    }
}

struct Wire {
    points: BinaryHeap<Point>,
    last: Point
}

impl Wire {
    pub fn new() -> Wire {
        let mut heap = BinaryHeap::new();
        let point = Point {x:0, y:0, steps: 0};
        heap.push(point.clone());

        Wire { points: heap, last: point }
    }

    pub fn add_point(self: &mut Wire, point: Point){
        self.points.push(point.clone());
        self.last = point;
    }

    pub fn last_point(self: &Wire) -> Point {
        self.last.clone()
        // self.points[self.points.len() - 1].clone()
    }

    pub fn goto_next(self: &mut Wire, movement: &Move ){
        let last = self.last_point();
        let Move { direction: direction, distance: distance } = movement;
        for dist in 1..(*distance + 1) {
            let mut point = last.clone();
            match *direction {
                "U" => point.moveUp(dist),
                "D" => point.moveDown(dist),
                "R" => point.moveRight(dist),
                "L" => point.moveLeft(dist),
                _ => (),
            }
            self.add_point(point);
        }
    }
}

// fn common(wire1: &mut Wire, wire2: &mut Wire) -> Vec<Point> {
fn minSteps(wire1: &mut Wire, wire2: &mut Wire) -> Option<i32> {
    // let mut commons = vec![];
    let mut nbSteps = None;

    let mut min1 = wire1.points.pop();
    min1 = wire1.points.pop();
    let mut min2 = wire2.points.pop();

    while (min1.is_some() && min2.is_some()){
        let mut distance = min1.clone().unwrap().distance();
        let curDist = distance.clone();
        let mut points1: Vec<Point> = vec![]; 

        while (distance == curDist && min1.is_some()){
            points1.push(min1.clone().unwrap()); 
            min1 = wire1.points.pop();
            if (min1.is_some()){
                distance = min1.clone().unwrap().distance();
            }
        }

        let mut distance = 0;
        if (min2.is_some()){
            distance = min2.clone().unwrap().distance();
        }
        let mut points2: Vec<Point> = vec![]; 
        while (distance <= curDist && min2.is_some()){
            if (distance == curDist ){
                points2.push(min2.clone().unwrap()); 
            }
            min2 = wire2.points.pop();

            if (min2.is_some()){
                distance = min2.clone().unwrap().distance();
                // println!("D1: {}, D2 : {}", curDist, distance);
            }
        }

        // println!("{} : {} : {}", curDist, &points1.len(), &points2.len());
        for p1 in &points1 {
            for p2 in &points2 {
                // println!("{:?} == {:?}", p1, p2);
                if p1.x == p2.x && p1.y == p2.y {
                    // println!("pushing.");
                    // let mut res_point = p1.clone();
                    // res_point.steps = res_point.steps + p2.steps;
                    let steps = p1.steps + p2.steps;
                    nbSteps = match nbSteps {
                        None => Some(steps),
                        Some(n) => if n < steps { Some(n) } else { Some(steps) }
                    };
                    // commons.push(res_point);
                }
            }
        }

    }
    // return commons;
    nbSteps
}

fn main(){
    let contents = fs::read_to_string("day3input.txt")
        .expect("Something went wrong reading the file");
//     let contents = "R8,U5,L5,D3
// U7,R6,D4,L4";

//     let contents = "R75,D30,R83,U83,L12,D49,R71,U7,L72
// U62,R66,U55,R34,D71,R55,D58,R83";

//     let contents = "R98,U47,R26,D63,R33,U87,L62,D20,R33,U53,R51
// U98,R91,D20,R16,D67,R40,U7,R15,U6,R7";
    let move_lists: Vec<Vec<Move>> = contents.lines().into_iter().map(|line| {
        line.trim().split(",").map(|s| new_move(s)).collect()
    }).collect();

    let mut wire1 = Wire::new();
    let mut wire2 = Wire::new();

    for mv in &move_lists[0] {
        wire1.goto_next(mv);
    }
    for mv in &move_lists[1] {
        wire2.goto_next(mv);
    }

    let com = minSteps(&mut wire1, &mut wire2);
    println!("{:?}", com);
    // match com {
    //     None => println!("No point"),
    //     Some(p) => println!("{:?} {}", p, p.distance())
    // }

}
